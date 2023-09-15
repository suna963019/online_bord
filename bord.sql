drop database if exists suna_practice;
create database suna_practice default character set utf8 collate utf8_general_ci;
drop user if exists 'owner'@'localhost';
create user 'owner'@'localhost' identified by 'anjera';
grant all on suna_practice.* to 'owner'@'localhost';
use suna_practice;

create table user (
	id int(11) auto_increment primary key not null, 
	name varchar(100) not null, 
	password varchar(100) not null
);

create table chat_data(
	id int auto_increment primary key, 
	name varchar(100), 
	datetime timestamp not null, 
	nice int(11) not null unique, 
	text varchar(1000) not null
);

insert into user values(null, 'owner', 'anjera');
insert into user values(null, 'Y','twitter' );
insert into chat_data values(null, 'owner',null
,0,'first comment');