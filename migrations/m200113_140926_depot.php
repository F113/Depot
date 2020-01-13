<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200113_140926_depot
 */
class m200113_140926_depot extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('drivers', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'birth' => Schema::TYPE_DATE,
        ]);

        $this->createTable('buses', [
            'id' => Schema::TYPE_PK,
            'mark' => Schema::TYPE_STRING,
            'model' => Schema::TYPE_STRING,
            'year' => Schema::TYPE_INTEGER,
            'speed' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('driver_bus', [
            'did' => Schema::TYPE_INTEGER,
            'bid' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('cities', [
            'id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING,
        ]);

        $this->createTable('distance', [
            'id1' => Schema::TYPE_INTEGER,
            'id2' => Schema::TYPE_INTEGER,
            'dist' => Schema::TYPE_INTEGER,
        ]);

        // insert some drivers
        $this->insert('drivers', [
            'id' => 1,
            'name' => 'John',
            'birth' => '1988-12-30'
        ]);
        $this->insert('drivers', [
            'id' => 2,
            'name' => 'Daniel',
            'birth' => '1983-05-16'
        ]);
        $this->insert('drivers', [
            'id' => 3,
            'name' => 'Jack',
            'birth' => '1994-02-11'
        ]);
        $this->insert('drivers', [
            'id' => 4,
            'name' => 'Sam',
            'birth' => '1990-11-02'
        ]);

        //insert some buses
        $this->insert('buses', [
            'id' => 1,
            'mark' => 'Mercedes',
            'model' => 'Travego',
            'year' => '2004',
            'speed' => '90',
        ]);
        $this->insert('buses', [
            'id' => 2,
            'mark' => 'Mercedes',
            'model' => 'Conecto',
            'year' => '2015',
            'speed' => '110',
        ]);
        $this->insert('buses', [
            'id' => 3,
            'mark' => 'Hyundai',
            'model' => 'Universe',
            'year' => '2018',
            'speed' => '120',
        ]);

        //insert drivers-bus relations
        $this->insert('driver_bus', [
            'did' => 1,
            'bid' => 1,
        ]);
        $this->insert('driver_bus', [
            'did' => 1,
            'bid' => 2,
        ]);
        $this->insert('driver_bus', [
            'did' => 2,
            'bid' => 2,
        ]);
        $this->insert('driver_bus', [
            'did' => 2,
            'bid' => 3,
        ]);
        $this->insert('driver_bus', [
            'did' => 3,
            'bid' => 1,
        ]);
        $this->insert('driver_bus', [
            'did' => 4,
            'bid' => 3,
        ]);

        //insert some cities
        $this->insert('cities', [
            'id' => 1,
            'name' => "Moscow",
        ]);
        $this->insert('cities', [
            'id' => 2,
            'name' => "Kazan",
        ]);

        //insert some distances
        $this->insert('distance', [
            'id1' => 1,
            'id2' => 2,
            'dist' => 800,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('drivers');
        $this->truncateTable('buses');
        $this->truncateTable('driver_bus');
        $this->truncateTable('cities');
        $this->truncateTable('distance');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200112_134226_depot cannot be reverted.\n";

        return false;
    }
    */
}
