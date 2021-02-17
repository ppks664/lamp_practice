-- 購入履歴テーブルのカラム
-- 注文番号、購入日時、該当の注文の合計金額、ユーザーid
CREATE TABLE histories(
    order_id int(11) NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_price int(11) NOT NULL,
    PRIMARY KEY(order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 --購入明細のテーブルカラム
 -- 商品名（item_id）、購入日時の商品価格、購入数,注文番号
CREATE TABLE details(
    details_id int(11) NOT NULL AUTO_INCREMENT, 
    item_id int(11) NOT NULL,
    order_id int(11) NOT NULL,
    amount int(11) NOT NULL,
    price int(11) NOT NULL,
    PRIMARY KEY(details_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;