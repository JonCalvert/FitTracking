<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserworkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userworkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workout_id');
            $table->integer('user_id');
            $table->dateTime('date');
            $table->integer('workout_reps');
            $table->integer('workout_weight');
            $table->text('workout_comment');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userworkouts');
    }
}




/*

drop procedure getUserWorkoutActivity$$


create procedure getUserWorkoutActivity( userId int)
            begin
            DECLARE done int default false;
            DECLARE w_name varchar(50);
            DECLARE w_date VARCHAR(50);
            DECLARE w_id int;
            DECLARE curs cursor for select distinct date_format( userworkouts.date, '%Y-%m-%d') as date from workouts right join userworkouts on workouts.workout_id = userworkouts.workout_id where userworkouts.user_id= userId;
            DECLARE continue handler for not found set done = 1;

            drop table if exists t3;
            CREATE temporary TABLE t3 as (select workouts.workout_name, date_format( userworkouts.date, '%Y-%m-%d') as date from workouts right join userworkouts on workouts.workout_id = userworkouts.workout_id where userworkouts.user_id= userId);  
            
            open curs;
                read_loop: LOOP
                fetch curs into w_date;
                    if done then
                        leave read_loop;
                    end if;

                    
                    insert into t2 (select distinct workout_name, date, count(workout_name) as count, 'workout' from t3 where date=w_date group by workout_name); 
                END LOOP;
            close curs;
            end;$$
            */




select distinct workout_name, date, count(workout_name) as count, 'workout' from t3 where date='2017-12-02' group by workout_name
