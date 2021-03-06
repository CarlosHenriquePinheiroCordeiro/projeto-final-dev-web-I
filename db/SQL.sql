/* CRIAÇÃO DO BANCO */
CREATE SCHEMA IF NOT EXISTS ESC;

USE ESC;

/* TABELAS */
CREATE TABLE TBTipoUsuario (
	TUSCodigo SMALLINT    NOT NULL AUTO_INCREMENT,
    TUSNome   VARCHAR(30) NOT NULL,
    PRIMARY KEY (TUSCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBUsuario (
	USUCodigo   BIGINT      NOT NULL AUTO_INCREMENT,
    USUId       VARCHAR(30) NOT NULL,
    USUSenha    TEXT        NOT NULL,
    USUAtivo    SMALLINT    NOT NULL DEFAULT 1,
    USUTermo    SMALLINT    NOT NULL DEFAULT 0,
    TUSCodigo   SMALLINT    NOT NULL,
	PRIMARY KEY (USUCodigo),
    FOREIGN KEY (TUSCodigo) REFERENCES TBTipoUsuario(TUSCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBPessoa (
	PESCodigo 		   BIGINT       NOT NULL AUTO_INCREMENT,
    PESNome            VARCHAR(100) NOT NULL,
    PESDataNascimento  DATE         NOT NULL,
    PESCpf 			   VARCHAR(11)  NOT NULL,
    PESRg 		       VARCHAR(7)   NOT NULL,
    USUCodigo 		   BIGINT 	    NOT NULL,
    PRIMARY KEY (PESCodigo),
    FOREIGN KEY (USUCodigo) REFERENCES TBUsuario(USUCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBProfessor (
    PROCodigo BIGINT NOT NULL AUTO_INCREMENT,
    PESCodigo BIGINT NOT NULL,
    PRIMARY KEY (PROCodigo),
    FOREIGN KEY (PESCodigo) REFERENCES TBPessoa(PESCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBAluno (
    ALUCodigo BIGINT NOT NULL AUTO_INCREMENT,
    PESCodigo BIGINT NOT NULL,
    PRIMARY KEY (ALUCodigo),
    FOREIGN KEY (PESCodigo) REFERENCES TBPessoa(PESCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBMateria (
	MATCodigo    INTEGER      NOT NULL AUTO_INCREMENT,
    MATNome      VARCHAR(50)  NOT NULL,
    MATDescricao VARCHAR(500) NOT NULL,
    PRIMARY KEY (MATCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBSalaVirtual (
	SALCodigo    INTEGER      NOT NULL AUTO_INCREMENT,
    SALNome      VARCHAR(100) NOT NULL,
    SALDescricao VARCHAR(500) NOT NULL,
    MATCodigo    INTEGER      NOT NULL,
    PRIMARY KEY (SALCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBSalaVirtualProfessor (
    SALCodigo INTEGER NOT NULL, 
	PROCodigo BIGINT  NOT NULL,
    PRIMARY KEY (SALCodigo, PROCodigo),
    FOREIGN KEY (PROCodigo) REFERENCES TBProfessor(PROCodigo),
    FOREIGN KEY (SALCodigo) REFERENCES TBSalaVirtual(SALCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBSalaVirtualAluno (
	SALCodigo INTEGER NOT NULL,
    ALUCodigo BIGINT  NOT NULL,
    PRIMARY KEY (SALCodigo, ALUCodigo),
    FOREIGN KEY (SALCodigo) REFERENCES TBSalaVirtual(SALCodigo),
    FOREIGN KEY (ALUCodigo) REFERENCES TBAluno(ALUCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE TBRegistroAula (
	RAUCodigo    INTEGER      NOT NULL AUTO_INCREMENT, 
    RAUDescricao VARCHAR(500) NOT NULL,
    RAUData      DATE         NOT NULL,
    RAUPresenca  JSON                 ,
    RAUQtdAulas  INTEGER      NOT NULL,
    SALCodigo    INTEGER      NOT NULL,
    PROCodigo 	 BIGINT 	          ,
    PRIMARY KEY (RAUCodigo),
    FOREIGN KEY (SALCodigo) REFERENCES TBSalaVirtual(SALCodigo),
    FOREIGN KEY (PROCodigo) REFERENCES TBSalaVirtualProfessor(PROCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* REGISTROS PADRÕES TESTE */
/* Tipos de Usuário */
INSERT INTO `TBTipoUsuario` (`TUSNome`)
                    VALUES 	('Administrador'),
                            ('Professor')	 ,
                            ('Aluno')		 ;

/* Usuários */
/* ID: admin | SENHA: admin */
INSERT INTO `TBUsuario` (`USUId`, `USUSenha`, `TUSCodigo`)
	             VALUES ('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1);
INSERT INTO `TBPessoa` (`PESNome`, `PESDataNascimento`, `PESCpf`, `PESRg`, `USUCodigo`)
                VALUES ('admin', '1980-11-09', '12345678912', '1234567', 1);
INSERT INTO `TBProfessor` (`PESCodigo`) VALUES (1);

/* ID: professor | SENHA: professor */
INSERT INTO `TBUsuario` (`USUId`, `USUSenha`, `TUSCodigo`)
	            VALUES  ('professor', '68d5fef94c7754840730274cf4959183b4e4ec35', 2);
INSERT INTO `TBPessoa` (`PESNome`, `PESDataNascimento`, `PESCpf`, `PESRg`, `USUCodigo`)
               VALUES  ('Rodrigo', '1980-11-09', '13524685912', '1234567', 2);
INSERT INTO `TBProfessor` (`PESCodigo`) VALUES (2);

/* ID: aluno | SENHA: aluno */
INSERT INTO `TBUsuario` (`USUId`, `USUSenha`, `TUSCodigo`)
	             VALUES ('aluno', '23a6a3cf06cfd8b1a6cda468e5756a6a6a1d21e7', 3);
INSERT INTO `TBPessoa` (`PESNome`, `PESDataNascimento`, `PESCpf`, `PESRg`, `USUCodigo`)
                VALUES ('Carlos Henrique', '2001-08-10', '14523694875', '7256418', 3);
INSERT INTO `TBAluno` (`PESCodigo`) VALUES (3);

/* ID: aluno2 | SENHA: aluno2 */
INSERT INTO `TBUsuario` (`USUCodigo`,`USUId`,`USUSenha`,`USUAtivo`,`USUTermo`,`TUSCodigo`) 
                 VALUES (4,'aluno2','b7ef9da90a2bd79099ebd48db885344a872bb155',1,0,3);
INSERT INTO `TBPessoa` (`PESCodigo`,`PESNome`,`PESDataNascimento`,`PESCpf`,`PESRg`,`USUCodigo`) 
                VALUES (4,'João','2000-07-12','12345678912','1234567',4);
INSERT INTO `TBAluno` (`ALUCodigo`,`PESCodigo`) VALUES (2,4);

/* ID: aluno3 | SENHA: aluno3 */
INSERT INTO `TBUsuario` (`USUCodigo`,`USUId`,`USUSenha`,`USUAtivo`,`USUTermo`,`TUSCodigo`) 
                 VALUES (5,'aluno3','629468c2baa740d9d6c605607dba9a99ef2397a3',1,0,3);
INSERT INTO `TBPessoa` (`PESCodigo`,`PESNome`,`PESDataNascimento`,`PESCpf`,`PESRg`,`USUCodigo`) 
               VALUES  (5,'Maria','2010-07-12','','',5);
INSERT INTO `TBAluno` (`ALUCodigo`,`PESCodigo`) VALUES (3,5);

/* ID: professor2 | SENHA: professor2 */
INSERT INTO `TBUsuario` (`USUCodigo`,`USUId`,`USUSenha`,`USUAtivo`,`USUTermo`,`TUSCodigo`) 
                 VALUES (6,'professor2','3edec810040804d5b678e1e9a8da386504e55029',1,0,2);
INSERT INTO `TBPessoa` (`PESCodigo`,`PESNome`,`PESDataNascimento`,`PESCpf`,`PESRg`,`USUCodigo`)
                VALUES (6,'ProfessorII','1990-07-12','12345678912','1234567',6);
INSERT INTO `TBProfessor` (`PROCodigo`,`PESCodigo`) VALUES (3,6);

/* Matérias */
INSERT INTO `TBMateria` (`MATNome`, `MATDescricao`)
                VALUES  ('Matemática'   , 'Estudo da matemática básica.'),
                        ('Português'    , 'Estudo do básico da língua portuguesa brasileira.'),
                        ('Geografia'    , 'Estudo da geografia básica.'),
                        ('Ciências'     , 'Estudo do básico das ciências.');

/* Salas Virtuais */
INSERT INTO `TBSalaVirtual` (`SALCodigo`,`SALNome`,`SALDescricao`,`MATCodigo`) VALUES (1,'Matemática I','Matemática I',1);
INSERT INTO `TBSalaVirtual` (`SALCodigo`,`SALNome`,`SALDescricao`,`MATCodigo`) VALUES (2,'Português I','Português I',2);
INSERT INTO `TBSalaVirtual` (`SALCodigo`,`SALNome`,`SALDescricao`,`MATCodigo`) VALUES (3,'Geografia I','Geografia I',3);

/* Sala Virtual x Professor */
INSERT INTO `TBSalaVirtualProfessor` (`SALCodigo`,`PROCodigo`) VALUES (1,1);
INSERT INTO `TBSalaVirtualProfessor` (`SALCodigo`,`PROCodigo`) VALUES (2,2);
INSERT INTO `TBSalaVirtualProfessor` (`SALCodigo`,`PROCodigo`) VALUES (2,3);
INSERT INTO `TBSalaVirtualProfessor` (`SALCodigo`,`PROCodigo`) VALUES (3,3);

/* Sala Virtual x Aluno */
INSERT INTO `TBSalaVirtualAluno` (`SALCodigo`,`ALUCodigo`) VALUES (1,1);
INSERT INTO `TBSalaVirtualAluno` (`SALCodigo`,`ALUCodigo`) VALUES (2,1);
INSERT INTO `TBSalaVirtualAluno` (`SALCodigo`,`ALUCodigo`) VALUES (2,2);
INSERT INTO `TBSalaVirtualAluno` (`SALCodigo`,`ALUCodigo`) VALUES (2,3);
INSERT INTO `TBSalaVirtualAluno` (`SALCodigo`,`ALUCodigo`) VALUES (3,3);

/* Registros de Aula */
INSERT INTO `TBRegistroAula` (`RAUCodigo`,`RAUDescricao`,`RAUData`,`RAUPresenca`,`RAUQtdAulas`,`SALCodigo`,`PROCodigo`) 
                      VALUES (1,'Aula I - Introdução aos números','2022-07-12','[{\"1\": [\"1\"]}, {\"2\": [\"1\"]}, {\"4\": [\"1\"]}, {\"5\": [\"1\"]}]',5,1,1);
INSERT INTO `TBRegistroAula` (`RAUCodigo`,`RAUDescricao`,`RAUData`,`RAUPresenca`,`RAUQtdAulas`,`SALCodigo`,`PROCodigo`) 
                      VALUES (2,'Aula I - Introdução ao Português','2022-07-12','[{\"1\": [\"1\", \"2\", \"3\"]}, {\"2\": [\"1\", \"2\"]}, {\"3\": [\"2\"]}, {\"4\": [\"2\", \"3\"]}, {\"5\": [\"3\"]}]',5,2,1);
INSERT INTO `TBRegistroAula` (`RAUCodigo`,`RAUDescricao`,`RAUData`,`RAUPresenca`,`RAUQtdAulas`,`SALCodigo`,`PROCodigo`) 
                      VALUES (3,'Aula II','2022-07-12','[{\"1\": [\"1\", \"2\", \"3\"]}, {\"2\": [\"1\", \"2\", \"3\"]}, {\"3\": [\"1\", \"2\", \"3\"]}, {\"4\": [\"2\", \"3\"]}, {\"5\": [\"1\"]}]',5,2,2);
