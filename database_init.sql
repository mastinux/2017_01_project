DROP database IF EXISTS `comments_db`;

create database `comments_db`;

use `comments_db`;

create table c_user(
	first_name varchar(320) not null,
	last_name varchar(320) not null,
	email varchar(320) not null,
	pw varchar(255) not null,
	primary key (email)
);

create table c_comment(
	email varchar(320) not null references c_user on delete cascade,
	c_text varchar(1024) not null,
    c_points tinyint unsigned not null check (c_points < 6),
    c_appreciation int unsigned not null default 0,
    primary key (email)
);

create table c_appreciation(
	email varchar(320) not null references c_user on delete cascade,
    c_comment varchar(320) not null references c_commnet on delete cascade,
    primary key (email, c_comment)
);

use `comments_db`;
select * from c_user;
select * from c_comment;