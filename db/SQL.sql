/* CRIAÇÃO DO BANCO */
CREATE SCHEMA IF NOT EXISTS ESC;

USE ESC;

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
    RAUPresenca  JSON         NOT NULL,
    PROCodigo 	 BIGINT 	  NOT NULL,
    SALCodigo    INTEGER      NOT NULL,
    PRIMARY KEY (RAUCodigo),
    FOREIGN KEY (SALCodigo) REFERENCES TBSalaVirtual(SALCodigo),
    FOREIGN KEY (PROCodigo) REFERENCES TBSalaVirtualProfessor(PROCodigo)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* INSERTS */
INSERT INTO `TBTipoUsuario` (`TUSNome`)
                    VALUES 	('Administrador'),
                            ('Professor')	 ,
                            ('Aluno')		 ;

/* ID: admin | SENHA: admin */
INSERT INTO `TBUsuario` (`USUId`, `USUSenha`, `TUSCodigo`)
	 VALUES ('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1);

/* ID: professor | SENHA: professor */
INSERT INTO `TBUsuario` (`USUId`, `USUSenha`, `TUSCodigo`)
	 VALUES ('professor', '68d5fef94c7754840730274cf4959183b4e4ec35', 2);
INSERT INTO `TBPessoa` (`PESNome`, `PESDataNascimento`, `PESCpf`, `PESRg`, `USUCodigo`)
              VALUES ('Professor', '1980-11-09', '13524685912', '2453619', 2);
INSERT INTO `TBProfessor` (`PESCodigo`)
                 VALUES (1);

/* ID: aluno | SENHA: aluno */
INSERT INTO `TBUsuario` (`USUId`, `USUSenha`, `TUSCodigo`)
	 VALUES ('aluno', '23a6a3cf06cfd8b1a6cda468e5756a6a6a1d21e7', 3);
INSERT INTO `TBPessoa` (`PESNome`, `PESDataNascimento`, `PESCpf`, `PESRg`, `USUCodigo`)
              VALUES ('Aluno', '2009-08-10', '14523694875', '7256418', 3);
INSERT INTO `TBAluno` (`PESCodigo`)
                 VALUES (2);

INSERT INTO `TBMateria` (`MATNome`, `MATDescricao`)
               VALUES   ('Matemática'   , 'Estudo da matemática básica.'),
                        ('Português'    , 'Estudo do básico da língua portuguesa brasileira.'),
                        ('Geografia'    , 'Estudo da geografia básica.'),
                        ('Ciências'     , 'Estudo do básico das ciências.');

INSERT INTO `TBSalaVirtual` (`SALCodigo`,`SALNome`,`SALDescricao`,`MATCodigo`) VALUES (1,'Matemática I','Matemática I',1);
INSERT INTO `TBSalaVirtual` (`SALCodigo`,`SALNome`,`SALDescricao`,`MATCodigo`) VALUES (2,'Português I','Português I',2);
INSERT INTO `TBSalaVirtual` (`SALCodigo`,`SALNome`,`SALDescricao`,`MATCodigo`) VALUES (3,'Geografia I','Geografia I',3);

INSERT INTO `TBSalaVirtualProfessor` (`SALCodigo`,`PROCodigo`) VALUES (1,1);

INSERT INTO `TBSalaVirtualAluno` (`SALCodigo`,`ALUCodigo`) VALUES (1,1);
INSERT INTO `TBSalaVirtualAluno` (`SALCodigo`,`ALUCodigo`) VALUES (2,1);