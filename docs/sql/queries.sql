
SELECT * FROM user;

select * from movement;

select id, user_id, movement_id, value, date 
from personal_record 
order by value desc;

# 1,Deadlift
# 2,Back Squat
# 3,Bench Press

select 
 pr.id personal_record, u.id, u.name username, m.name moviment, pr.date, pr.value 
from user u
inner join personal_record pr on u.id = pr.user_id
inner join movement m on m.id = pr.movement_id
where pr.movement_id = 2
order by pr.value DESC;


with movement_id as (
    select id
    from movement
    where name = '' OR id = 2
), personal_records_movement as (
    select id, user_id, movement_id, value, date
    from personal_record
    where movement_id = (SELECT id FROM movement_id)
) select * 
  from 
      personal_records_movement prm
  inner join 
      user u on u.id = prm.user_id 
  order by value desc;


select id
from movement
where name = '' OR id = 2;

select id, user_id, movement_id, value, date
from personal_record
where movement_id = (select id
                     from movement
                     where name = '' OR id = 2);


SELECT
    pr.id,
    pr.user_id,
    pr.movement_id,
    pr.value,
    pr.date,
    ROW_NUMBER() OVER(
        PARTITION BY pr.user_id, pr.movement_id
        ORDER BY pr.value DESC, pr.date DESC) AS rn
FROM
    personal_record pr
where movement_id = 1;

    
    
# Case 1
# Back Squat,Joao,130,2021-01-03 00:00:00,1
# Back Squat,Jose,130,2021-01-03 00:00:00,1
# Back Squat,Paulo,125,2021-01-03 00:00:00,2

# Case 2 - order by personal_record_date
# Back Squat,Joao,130,2021-01-03 00:00:00,1
# Back Squat,Jose,130,2021-01-03 00:00:10,1
# Back Squat,Paulo,125,2021-01-03 00:00:00,2

WITH movement_id as (
    select id
    from movement
    where name = '' OR id = 3
), personal_records_movement as (
    select id, user_id, movement_id, value, date
    from personal_record
    where movement_id = (SELECT id FROM movement_id)
), user_best_personal_record AS (
    SELECT
        pr.id,
        pr.user_id,
        pr.movement_id,
        pr.value,
        pr.date,
        ROW_NUMBER() OVER(
            PARTITION BY pr.user_id, pr.movement_id 
            ORDER BY pr.value DESC, pr.date DESC) AS rn
    FROM
        personal_records_movement pr
)
SELECT
    m.name AS movement_name,
    u.name AS user_name,
    ubpr.value AS personal_record_user,
    ubpr.date AS personal_record_date,
    DENSE_RANK() OVER (ORDER BY ubpr.value DESC) AS position
FROM
    user_best_personal_record ubpr
        JOIN
    user u ON ubpr.user_id = u.id
        JOIN
    movement m ON ubpr.movement_id = m.id
WHERE
    ubpr.rn = (SELECT id FROM movement_id)
ORDER BY
    personal_record_user DESC,
    personal_record_date;