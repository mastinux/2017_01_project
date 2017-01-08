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
    c_points tinyint unsigned not null check (c_points <= 5),
    c_appreciation int unsigned not null default 0,
    primary key (email)
);

create table c_judge(
	email varchar(320) not null references c_user on delete cascade,
    c_comment varchar(320) not null references c_comment on delete cascade,
    plus tinyint not null default 0,
    minus tinyint not null default 0,
    primary key (email, c_comment),
    check ((plus + minus) <= 3)
);

insert into c_user values('a', 'p', 'ap@gmail.com', md5('ap'));
insert into c_user values('a', 'f', 'af@gmail.com', md5('af'));
insert into c_user values('p', 'c', 'pc@gmail.com', md5('pc'));

insert into c_comment(email, c_text, c_points) values('pc@gmail.com', 'Pessimo.', 0);
insert into c_comment(email, c_text, c_points) values('ap@gmail.com', 'Discreto.', 4);
insert into c_comment(email, c_text, c_points) values('af@gmail.com', 'Ottimo.', 5);

use `comments_db`;
select * from c_user;
select * from c_comment;
select * from c_judge;