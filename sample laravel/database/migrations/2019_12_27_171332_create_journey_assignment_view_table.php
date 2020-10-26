<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneyAssignmentViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::statement("CREATE OR REPLACE VIEW journey_assignment_view AS	
			select 
				`j`.`id` as journey_id, 
				`j`.`parent_id` as journey_parent_id, 
				`j`.`journey_name`, 
				`j`.`journey_type_id`, 
				`ja`.`id` as `assignment_id`, 
				`ja`.`assignment_type`,
				`ja`.`user_id`,
				CONCAT(`u3`.`first_name`,' ',`u3`.`last_name`) as user_name,				
				(CASE WHEN (j.journey_type_id = 2) THEN 
				(SELECT 
						count(id) 
					FROM 
						milestones 
					WHERE 
						journey_id = j.id 
						AND deleted_at IS NULL
				)
				ELSE
				(SELECT 
						count(ma1.id) 
					FROM 
						milestones as m1 LEFT JOIN milestone_assignments as ma1 ON m1.id = ma1.milestone_id
					WHERE 
						ma1.journey_id = j.id 
						AND ma1.journey_id = j.id 
						AND ma1.user_id = ja.user_id 
						AND ma1.assignment_type = ja.assignment_type 
						AND ma1.status != 'revoked' 
						AND m1.deleted_at IS NULL
				 ) END)  as milestone_count, 
				`j`.`read`, 
				`j`.`visibility`, 
				`j`.`status`, 
				`ja`.`status` as assigned_status, 
				`j`.`type` as j_type, 
				`j`.`type_ref_id` as j_type_ref_id,
				`ja`.`type`, 
				`ja`.`type_ref_id`,	
				(CASE WHEN (u2.first_name IS NOT NULL AND u2.first_name != '') THEN CONCAT(`u2`.`first_name`,' ',`u2`.`last_name`)
				WHEN (group.group_name IS NOT NULL AND group.group_name != '') THEN `group`.`group_name`
				WHEN (grade.node_name IS NOT NULL AND grade.node_name != '') THEN `grade`.`node_name` ELSE NULL END) as type_name,
				ROUND(
					(
						(
							(
								SUM(
									CASE WHEN (`ma`.status = 'completed' AND ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN 1 ELSE 0 END
								)
							)/ 
							(
								SUM(
									CASE WHEN (ja.user_id = ma.user_id AND `ma`.status != 'revoked' AND ma.assignment_type = ja.assignment_type) THEN 1 ELSE 0 END
								)
							)
						)* 100
					)
				) AS complete_percentage,
				SUM(
					CASE WHEN (`ma`.status = 'completed' AND ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN 1 ELSE 0 END
				) AS completed_milestone_count,
				SUM(
					CASE WHEN (`ma`.status = 'revoked' AND ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN 1 ELSE 0 END
				) AS revoked_milestone_count,				
				MAX(`m`.end_date) as targeted_complete_date,
				GROUP_CONCAT(DISTINCT `m`.`tags`) as tags, 
				CONCAT(`u`.`first_name`,' ',`u`.`last_name`) as assigned_name, 
				CONCAT(`u1`.`first_name`,' ',`u1`.`last_name`) as created_name,
				`ja`.`created_at` as  assigned_at, 
				`j`.`created_at` as  created_at, 
				`ja`.`created_by` as  assigned_by,
				`j`.`created_by` as  created_by
			from 
				`journeys` as `j` 
				left join `journey_assignments` as `ja` on `j`.`id` = `ja`.`journey_id` 
				left join `milestones` as `m` on `m`.`journey_id` = `j`.`id` 
				left join `milestone_assignments` as `ma` on `ma`.`milestone_id` = `m`.`id` 
				left join `users` as `u` on `u`.`id` = `ja`.`created_by` 
				left join `users` as `u1` on `u1`.`id` = `j`.`created_by`
				left join `users` as `u2` on (`u2`.`id` = `ja`.`type_ref_id` AND `ja`.`type` = 'user')
				left join `users` as `u3` on (`u3`.`id` = `ja`.`user_id`)
				left join `groups` as `group` on (`group`.`id` = `ja`.`type_ref_id` AND `ja`.`type` = 'group')
				left join `organization_charts` as `grade` on (`grade`.`id` = `ja`.`type_ref_id` AND `ja`.`type` = 'grade') 	
			where 
				`j`.`deleted_at` IS NULL AND
				`m`.`deleted_at` IS NULL 
			group by 
				`j`.`id`, 
				`ja`.`id` 
			order by 
				`ja`.`id` desc");
				
			
			DB::statement("CREATE OR REPLACE VIEW passport_journey_view AS		
				select 
					`ja`.`user_id`,	
					`j`.`id` as journey_id,  
					`j`.`journey_name`,
					`j`.`journey_type_id`,
					`j`.`visibility`,
					SUM(
						CASE WHEN (`ma`.status = 'completed' AND ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN ma.point ELSE 0 END
						) as points,
					AVG(
						CASE WHEN (`ma`.status = 'completed' AND ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN ma.rating ELSE Null END
						) as ratings,
					
					(CASE WHEN (GROUP_CONCAT(DISTINCT (CASE WHEN (`ma`.status != 'revoked' AND ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN `ma`.status ELSE Null END)) = 'completed') THEN MAX(`ma`.completed_date) ELSE Null END) as completed_date,
					(CASE WHEN (j.id = 2) THEN 100 ELSE
					(ROUND(
						(
							(
								(
									SUM(
										CASE WHEN (`ma`.status = 'completed' AND ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN 1 ELSE 0 END
									)
								)/ 
								(
									SUM(
										CASE WHEN (ja.user_id = ma.user_id AND `ma`.status != 'revoked' AND ma.assignment_type = ja.assignment_type) THEN 1 ELSE 0 END
									)
								)
							)* 100
						)
					)) END) AS complete_percentage,
					`j`.`status`, 
					`ja`.`status` as assigned_status,
					GROUP_CONCAT(DISTINCT CASE WHEN (ja.user_id = ma.user_id AND ma.assignment_type = ja.assignment_type) THEN `ma`.status ELSE Null END) as milestone_assigned_status, 
					CONCAT(`u`.`first_name`,' ',`u`.`last_name`) as assigned_name, 
					`ja`.`created_by` as  assigned_by,
					`j`.`deleted_at`
				from 
					`journeys` as `j` 
					left join `journey_assignments` as `ja` on `j`.`id` = `ja`.`journey_id` 
					left join `milestones` as `m` on `m`.`journey_id` = `j`.`id` 
					left join `milestone_assignments` as `ma` on `ma`.`milestone_id` = `m`.`id` 
					left join `users` as `u` on `u`.`id` = `ja`.`created_by` 
				where
					j.journey_type_id != 2 
				group by 
					`j`.`id`, 
					`ja`.`id` 
				order by 
					`ja`.`id` desc");
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('journey_assignment_view');
        //DB::statement("DROP VIEW journey_assignment_view");
    }
}
