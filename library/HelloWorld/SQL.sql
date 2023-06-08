-- 创建视图
CREATE VIEW sales_summary AS
SELECT
    product_id,
    SUM(quantity) AS total_quantity,
    AVG(price) AS average_price,
    MAX(price) AS max_price
FROM
    sales
GROUP BY
    product_id;

-- 创建存储过程
DELIMITER //
CREATE PROCEDURE calculate_discount(
    IN product_id INT,
    OUT discount DECIMAL(10, 2)
)
BEGIN
    DECLARE total_sales INT;
    DECLARE total_discount DECIMAL(10, 2);
    
    -- 计算总销售量
    SELECT SUM(quantity) INTO total_sales
    FROM sales
    WHERE product_id = product_id;
    
    -- 根据销售量计算折扣
    IF total_sales > 1000 THEN
        SET discount = 0.1;
    ELSEIF total_sales > 500 THEN
        SET discount = 0.05;
    ELSE
        SET discount = 0;
    END IF;
    
    -- 计算总折扣金额
    SET total_discount = total_sales * discount;
    
    -- 返回折扣金额
    SELECT total_discount;
END //
DELIMITER ;

-- 调用存储过程并获取结果
SET @product_id = 1;
CALL calculate_discount(@product_id, @discount);
SELECT @discount;
