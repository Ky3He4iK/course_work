CREATE DATABASE IF NOT EXISTS disks_db_736;
USE disks_db_736;

CREATE TABLE IF NOT EXISTS USERS
(
    id        int         NOT NULL PRIMARY KEY AUTO_INCREMENT,
    login     varchar(40) NOT NULL UNIQUE,
    user_name varchar(80) NOT NULL,
    salt      varchar(41) NOT NULL,
    password  varchar(41) NOT NULL,
    is_admin  boolean     NOT NULL DEFAULT FALSE
) DEFAULT CHARSET = utf8;

INSERT INTO USERS (login, user_name, salt, password, is_admin) VALUE ('admin@ky3he4ik.dev', 'Administrator', 'q2435t5tgfw', SHA1(ENCRYPT('admin_password', 'q2435t5tgfw')), true);


CREATE TABLE IF NOT EXISTS DISKS
(
    id            int  NOT NULL PRIMARY KEY AUTO_INCREMENT,
    manufacturer  text NOT NULL,
    model         text NOT NULL,
    description   text NOT NULL,
    capacity      int  NOT NULL,
    price         int  NOT NULL,
    transfer_rate int  NOT NULL,
    interface     text NOT NULL
) DEFAULT CHARSET = utf8;

-- INSERT INTO DISKS (manufacturer, model, description, capacity, price, transfer_rate, interface) VALUES ()

CREATE TABLE IF NOT EXISTS ORDERS
(
    order_id         int         NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id          int         NOT NULL,
    price            int         NOT NULL,
    delivery_address text        NOT NULL,
    additional_info  text        NOT NULL,
    city             varchar(30) NOT NULL,
    FOREIGN KEY ORDERS (user_id) REFERENCES USERS (id)
) DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS ORDER_DETAILS
(
    order_id   int NOT NULL,
    disk_id    int NOT NULL,
    disk_count int NOT NULL,
    FOREIGN KEY order_details_order (order_id) REFERENCES ORDERS (order_id),
    FOREIGN KEY order_details_disk (disk_id) REFERENCES DISKS (id)
) DEFAULT CHARSET = utf8;
