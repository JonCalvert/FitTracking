<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->increments('food_id');
            $table->string('food_name');
            $table->integer('food_calories');
            $table->float('food_protein');
            $table->float('food_carbs');
            $table->float('food_fats');
            
        });
        
        
        
        
        /*
        drop procedure getUserFoodActivity$$
       create procedure getUserFoodActivity( userId int)
            begin
            DECLARE done int default false;
            DECLARE f_name varchar(50);
            DECLARE f_date VARCHAR(50);
            DECLARE f_id int;
            DECLARE curs cursor for select distinct date_format( userfoods.date, '%Y-%m-%d') as date from foods right join userfoods on foods.food_id = userfoods.food_id where userfoods.user_id= userId;
            DECLARE continue handler for not found set done = 1;
            
            drop table if exists t1;
            drop table if exists t2;
            CREATE temporary TABLE t1 as (select foods.food_name, date_format( userfoods.date, '%Y-%m-%d') as date from foods right join userfoods on foods.food_id = userfoods.food_id where userfoods.user_id= userId); 
            CREATE TABLE t2 (name varchar(255), date varchar(10), count int, type varchar(10) ); 
            Create table if not exists lastUpdated ( user_id int, date datetime );
            delete from lastUpdated where user_id= userId;
            insert into lastUpdated values( userId, NOW() );
            
            open curs;
                read_loop: LOOP
                    fetch curs into f_date;
                    if done then
                        leave read_loop;
                    end if;

                    
                    insert into t2 (select food_name, date, count(food_name) as count, 'food' from t1 where date=f_date group by food_name); 
                END LOOP;
            close curs;
            end; $$
        
        */
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('foods');
    }
}
