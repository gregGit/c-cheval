drop schema if exists _cheval;

CREATE SCHEMA c_cheval DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
use c_cheval

drop table if exists cc_movement_element;
drop table if exists cc_movement;
drop table if exists cc_reprise;
drop table if exists cc_categorie;

create table cc_categorie(
id int not null auto_increment,
name varchar(100) not null,
label varchar(2000) null default null,
primary key(id)
);


create table cc_reprise (
id int not null auto_increment,
name varchar(100) not null,
long_name varchar(2000) null default null,
reglement varchar(2000) null default null,
type CHAR(1) not null,
annee char(4) not null,
categorie int null default null,
primary key(id)
);


create table cc_movement(
id int not null auto_increment,
position int not null,
coef int not null default 1, 
criteria varchar(500),
reprise int not null,
primary key(id)
);

create table cc_movement_element(
id int not null auto_increment,
position int not null,
letter varchar(3) not null,
label varchar(100) not null,
movement int not null,
primary key(id)
);


alter table cc_reprise add constraint fk_reprise_categorie FOREIGN key (categorie) REFERENCES cc_categorie(id) on delete set null;
alter table cc_movement add constraint fk_movement_reprise FOREIGN key (reprise) REFERENCES cc_reprise(id) on delete cascade on update cascade;
alter table cc_movement_element add constraint fk_element_movement FOREIGN key (movement) REFERENCES cc_movement(id) on delete cascade on update cascade;


insert into cc_categorie (name,label) values('Club', 'Reprises Club');
insert into cc_categorie (name,label) values('Ponam', 'Reprises Ponam');
insert into cc_categorie (name,label) values('Amateur', 'Reprises Amateur');
insert into cc_categorie (name,label) values('Pro', 'Reprises Pro');



insert into cc_reprise( name, long_name, type, annee, categorie, reglement) values('amateur 2 imposée A', 'Reprise Amateur 2 imposée A (C3)', 'S', '2015', 3, 'Reprise à présenter sur un rectangle de 60 m x 20 m
En filet ou bride - Éperons obligatoires.
Cravache autorisée 
(Pour les chevaux de moins de 6 ans filet obligatoire)');



insert into cc_movement(position, coef, reprise, criteria) values(1, 1,1, 'La qualité des allures, de l''arrêt et des transitions. La rectitude. Le contact et la nuque.');
insert into cc_movement_element(position, letter, label, movement) values(1, 'A', 'Entrée au trot de travail', 1);
insert into cc_movement_element(position, letter, label, movement) values(2, 'X', 'Arrêt. Immobilité. Salut.', 1);
insert into cc_movement_element(position, letter, label, movement) values(3, 'XC', 'Rompre au trot de travail', 1);

insert into cc_movement(position, coef, reprise, criteria) values(2, 1,1, 'Régularité, élasticité et équilibre.\nEnergie et amplitude des foulées.\nL''attitude et les transitions.');
insert into cc_movement_element(position, letter, label, movement) values(1, 'C', 'Piste à main droite', 2);
insert into cc_movement_element(position, letter, label, movement) values(2, 'RK', 'Changement de main au trot moyen', 2);
insert into cc_movement_element(position, letter, label, movement) values(3, 'KAF', 'Trot de travail.', 2);


insert into cc_movement(position, coef, reprise, criteria) values(1, 1,1, '');
insert into cc_movement_element(position, letter, label, movement) values(1, '', '', 1);




