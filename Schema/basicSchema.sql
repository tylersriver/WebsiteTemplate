create database BasicWebsite;

drop table if exists `user`;
create table `user` (
    userId int(11) AUTO_INCREMENT primary key,
    username varchar(256),
    password varchar(512)
);
insert into user (username, password) VALUES ('admin', '$2y$10$2e4PA8LteeZU0/tLdqQ/H.U.ltTa18TWpa4FTbM8YflWDZjvXpw.m');
