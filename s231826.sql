use s231826;

create table c_user(
	first_name varchar(320) not null,
	last_name varchar(320) not null,
	email varchar(320) not null,
	pw varchar(255) not null,
	primary key (email)
);

create table c_comment(
	email varchar(320) not null,
	c_text varchar(1024) not null,
    c_points tinyint unsigned not null check (c_points <= 5),
    constraint fk_c_user foreign key (email) references c_user(email) on delete cascade,
    primary key (email)
);

create table c_judge(
	email varchar(320) not null,
    c_comment varchar(320) not null,
    plus_count tinyint not null default 0,
    minus_count tinyint not null default 0,
    c_judge_count tinyint not null default 1 check (c_judge_count between 1 and 3),
    primary key (email, c_comment)
);

alter table `c_judge`
add constraint fk_c_judge_c_user
foreign key (`email`)
references `c_user`(`email`)
on delete cascade;

alter table `c_judge`
add constraint fk_c_judge_c_comment
foreign key (`c_comment`)
references `c_comment`(`email`)
on delete cascade;

insert into c_user values('u', '1', 'u1@p.it', md5('p1'));
insert into c_user values('u', '2', 'u2@p.it', md5('p2'));
insert into c_user values('u', '3', 'u3@p.it', md5('p3'));

insert into c_comment(email, c_text, c_points) values('u1@p.it', 'Migliorabile.', 3);
insert into c_comment(email, c_text, c_points) values('u2@p.it', 'Da provare.', 4);
insert into c_comment(email, c_text, c_points) values('u3@p.it', 'Pessimo.', 1);

insert into c_judge(email, c_comment, plus_count, minus_count, c_judge_count)
values('u1@p.it', 'u2@p.it', 3, 0, 3);
insert into c_judge(email, c_comment, plus_count, minus_count, c_judge_count)
values('u1@p.it', 'u3@p.it', 1, 0, 1);

insert into c_judge(email, c_comment, plus_count, minus_count, c_judge_count)
values('u2@p.it', 'u1@p.it', 0, 1, 1);
insert into c_judge(email, c_comment, plus_count, minus_count, c_judge_count)
values('u2@p.it', 'u3@p.it', 0, 2, 2);