CREATE PROCEDURE lms.pr_criar_sumario_estudo_usuario(IN user_id INT, IN order_id INT)
  COMMENT 'Liberação de grade para o curso comprado'
BEGIN

  DECLARE x_course_id FLOAT;
  DECLARE x_citie_id FLOAT;
  DECLARE x_state_id FLOAT;
  DECLARE x_summaries_id FLOAT;

  DECLARE is_user_module_summaries FLOAT;

  SET is_user_module_summaries = (SELECT count(1) FROM user_module_summaries WHERE user_id = user_id AND order_id = order_id LIMIT 0,1);

   IF is_user_module_summaries = 0 THEN
      
      SELECT course_id, citie_id, state_id
        INTO x_course_id, x_citie_id, x_state_id
        FROM order_courses
        WHERE order_id = order_id;
    
      INSERT INTO user_module_summaries (order_id, user_id, module_id, module_discipline_id, desblock)
      SELECT order_id, user_id, a.module_id, b.id, 0  
        FROM module_courses a 
          INNER JOIN module_disciplines b ON b.module_id = a.module_id
        WHERE a.course_id = x_course_id
          AND a.citie_id = x_citie_id 
          AND a.state_id = x_state_id;

      SET x_summaries_id = (SELECT id FROM user_module_summaries WHERE user_id = user_id AND order_id = order_id ORDER BY id ASC LIMIT 0,1);

      UPDATE user_module_summaries SET desblock = 1 WHERE id = x_summaries_id;

   END IF;

END