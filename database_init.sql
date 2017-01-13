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
    primary key (email)
);

create table c_judge(
	email varchar(320) not null references c_user on delete cascade,
    c_comment varchar(320) not null references c_comment on delete cascade,
    plus_count tinyint not null default 0,
    minus_count tinyint not null default 0,
    c_judge_count tinyint not null default 1 check (c_judge_count between 1 and 3),
    primary key (email, c_comment)
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

update c_judge
set plus_count = (plus_count + 1), c_judge_count = (c_judge_count + 1)  
where email = 'ap@gmail.com' and c_comment = 'af@gmail.com';
/*
insert into c_judge(email, c_comment, plus_count, minus_count) values('ap@gmail.com', 'af@gmail.com', 1, 0);

update c_judge
set plus_count = (plus_count + 1) and c_judge_count = (c_judge_count + 1)
where email = 'ap@gmail.com' and c_comment = 'af@gmail.com';

select * from c_judge;