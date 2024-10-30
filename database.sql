create database qlsv;
use qlsv;

create TABLE if not exists Account(
    id int(11) not null AUTO_INCREMENT primary key,
    email varchar(100) not null UNIQUE,
    name longtext not null,
    password longtext not null,
    role longtext not null
);

-- pass: Admin123@
insert into Account(name, email, password, role) values ("Admin", "admin@gmail.com", "b39abbe763440b02c231b2653ebd9da3ea78dcb1", "admin");

create table if not exists Major(
    id int(11) not null AUTO_INCREMENT primary key,
    name longtext not null UNIQUE
);

insert into Major(name) values ('Kĩ thuật phần mềm'), ('Khoa học máy tính'), ('Hệ thống thông tin'), ('Công nghệ thông tin');

create table if not exists Teacher(
    id int(11) not null AUTO_INCREMENT primary key,
    accountID int(11) not null,
    gender boolean not null,
    address longtext not null,
    phoneNumber varchar(15) not null,
    birthday date not null,
    foreign key(accountID) references Account(id)
);

create table if not exists Student(
    id int(11) not null AUTO_INCREMENT primary key,
    accountID int(11) not null,
    majorID int(11) not null,
    gender boolean not null,
    address longtext not null,
    phoneNumber varchar(15) not null,
    birthday date not null,
	foreign key(accountID) references Account(id),
    foreign key(majorID) references Major(id)
);

create table if not exists Class(
    id int(11) not null AUTO_INCREMENT primary key,
    name longtext not null UNIQUE,
    teacherID int(11) not null,
    foreign key(teacherID) references Teacher(id)
);

create table if not exists ClassDetail(
    id int(11) not null AUTO_INCREMENT primary key,
    classID int(11) not null,
    studentID int(11) not null,
    foreign key(studentID) references Student(id),
    foreign key(classID) references Class(id)
);

create table if not exists Score( 
    id int(11) not null AUTO_INCREMENT primary key, 
    studentID int(11) not null, 
    classID int(11) not null, 
    score1 double, 
    score2 double,
    score3 double,
    foreign key(studentID) references Student(id),
    foreign key(classID) references Class(id)
);