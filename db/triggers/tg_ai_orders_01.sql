CREATE TRIGGER tg_ai_orders_01
	AFTER INSERT
	ON orders
	FOR EACH ROW
BEGIN
  IF NEW.order_type_id = 3 THEN BEGIN
    CALL pr_criar_sumario_estudo_usuario(NEW.user_id,NEW.id);
  END; END IF;
END