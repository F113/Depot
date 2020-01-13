<?php

namespace app\controllers;

use Yii;
use app\models\Buses;
use app\models\Drivers;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

class SiteController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return mixed
     */
    public function actionBuses()
    {
        $query = Buses::find();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ]
        ]);

        return $this->renderPartial('buses_grid', ['provider' => $provider]);
    }

    /**
     * @return mixed
     */
    public function actionDrivers()
    {
        $query = Drivers::find()->orderBy('name');

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ]
        ]);

        return $this->renderPartial('drivers_grid', ['provider' => $provider]);
    }

    /**
     * get distance between city1 and city2
     *
     * @param $id1 int
     * @param $id2 int
     * @return mixed
     */
    public function findDistance($id1, $id2)
    {
        $row = (new \yii\db\Query())
            ->select(['dist'])
            ->from('distance')
            ->where('id1 = :id1 AND id2 = :id2')
            ->orWhere('id1 = :id2 AND id2 = :id1')
            ->addParams([':id1' => $id1, ':id2' => $id2])
            ->limit(1)
            ->one();

        return $row;
    }

    /**
     * @return mixed
     */
    public function actionDistance()
    {
        $data = \Yii::$app->request->get();

        //check params correction
        if (!isset($data['id1'])) throw new HttpException(404, 'Missed id1');
        if (!isset($data['id2'])) throw new HttpException(404, 'Missed id2');
        $dist = $this->findDistance($data['id1'], $data['id2'])['dist'];
        if ($dist == 0) throw new HttpException(404, 'Missed distance');

        //build query
        $query = Drivers::find()
            ->select(['d.id', 'd.name', 'd.birth', 'time' => 'round(:dist/max(b.speed), 1)'])
            ->addParams([':dist' => $dist])
            ->from('drivers as d')
            ->join('INNER JOIN', 'driver_bus as db', 'd.id=db.did')
            ->join('INNER JOIN', 'buses as b', 'b.id=db.bid')
            ->groupBy('d.id')
            ->orderBy(['time' => SORT_ASC]);


        if (!isset($data['did'])) {
            //show all drivers
            $provider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 3,
                ]
            ]);
            return $this->renderPartial('distance_grid', ['provider' => $provider]);
        } else {
            //show one driver by did
            $result = $query->where('d.id = :did')
                ->addParams([':did' => $data['did']])
                ->one();
            if ($result) {
                $attrs = $result->getAttributes(array('id', 'name', 'time', 'birth'));

                echo json_encode([
                    "id" => $attrs['id'],
                    "name" => $attrs['name'],
                    "birth_date" => $attrs['birth'],
                    "age" => (int)Yii::$app->formatter->asRelativeTime($attrs['birth']),
                    "travel_time" => $attrs['time']
                ]);
                return;
            }

        }
    }


}
