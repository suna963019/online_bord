drop database if exists suna_bord;
create database suna_bord default character set utf8 collate utf8_general_ci;
drop user if exists 'owner'@'localhost';
create user 'owner'@'localhost' identified by 'anjera';
grant all on suna_bord.* to 'owner'@'localhost';
use suna_bord;

create table user (
	user_id int(11) auto_increment primary key not null, 
	name varchar(100) not null, 
	password varchar(100) not null
);

create table chat_data(
	id int auto_increment primary key, 
	name_id int(11) not null, 
	datetime timestamp not null, 
	text varchar(1000) not null,
	foreign key(name_id) references user(user_id)
);
create table nice(
	user_id int(11) not null , 
	chat_id int(11) not null ,
	foreign key(user_id) references user(user_id),
	foreign key(chat_id) references chat_data(id),
	primary key(user_id,chat_id)
);

insert into user values(null, 'owner', 'anjera');
insert into user values(null, 'Y','twitter' );
insert into chat_data values(null,1,null,'first comment');
insert into nice values( 1,1 );
insert into nice values( 2,1 );