CREATE DATABASE IF NOT EXISTS ToDoListe;
USE ToDoListe;
CREATE TABLE IF NOT EXISTS todo (
id bigint(20) NOT NULL AUTO_INCREMENT,
title varchar(2048) NOT NULL,
done tinyint(1) NOT NULL DEFAULT 0,
created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
);
create table Users(
user_name varchar(100) primary key,
password varchar(8) 
);
select * from todo;

#INSERTION DANS TAB TODO-----------------------------------------------------------------------------------------------------------------------------------
insert into todo values(1,"title1",1,"2023-12-21");
insert into todo values(2,"title2",0,"2023-12-30");
insert into todo values(3,"title3",1,"2024-01-19");
insert into todo values(4,"title4",0,"2024-01-24");
insert into todo values(5,"title5",1,"2023-12-29");

#INSERTION DANS TAB USERS-----------------------------------------------------------------------------------------------------------------------------------
select * from Users;
insert into Users values("oussama","osm.be12");
insert into Users values("Aymen","aymn.123");
insert into Users values("ahmed","ahmed123");


























Create database address_book;

create table
    customers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name varchar(40),
        email varchar(80),
        mobile varchar(40)
    );