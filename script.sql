create database trab3;
use trab3;

create table Tutor(
	CPF int not null primary key,
	Senha varchar(200) not null,
	Nome varchar(1000) not null,
	Login varchar(200) not null,
	DataNascimento date not null,
	Endereco varchar(2000) not null
);


create table Rastreador(
	DataCadastro date not null,
	DataAtivacao date not null,
	Identificador int not null primary key auto_increment,
	CPF_Tutor int not null,
	foreign key(CPF_Tutor)references Tutor(CPF)
);

create table Pet(
	IdPet int not null primary key auto_increment,
	Nome varchar(400) not null,
	Tipo varchar(200) not null,
	DataNascimento date not null,
	Sexo char(1) not null,
	CPF_Tutor int not null,
	foreign key(CPF_Tutor) references Tutor(CPF)
);

create table Pet_Rastreador(
	IdRastreador int not null,
	IdPet int not null,
	Identificador int not null primary key auto_increment,
	DataHora datetime not null,
	Georeferencia varchar(2000) null,
	foreign key(IdRastreador)references Rastreador(Identificador),
	foreign key(IdPet)references Pet(IdPet)
);