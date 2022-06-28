<?php
require_once('autoload.php');
$tipoUsuario = new TipoUsuario(1, 'Admin');
$usuario = new Usuario(1, 'idCarlos', 'senhaCarlos', 1, 1, $tipoUsuario);
$pessoa = new Pessoa(1, 'Carlos', '10/08/2001', '1234567812', '1234567', $usuario);
$aluno = new Aluno(1, $pessoa);
$responsavel = new Responsavel(1, $pessoa);
$responsavelAluno = new ResponsavelAluno($responsavel, $aluno);
$professor = new Professor(1, $pessoa);
$materia = new Materia(1, 'matematica', 'asdasdsa');
$salaVirtual = new SalaVirtual(1, 'salaMatematica', $materia);
$salaVirtualAluno = new SalaVirtualAluno($salaVirtual, $aluno);
$salaVirtualProfessor = new SalaVirtualProfessor($salaVirtual, $professor);
$registroAula = new RegistroAula(1, 'Aula de Matemática', '2022-06-28', $salaVirtual);
$registroAulaAluno = new RegistroAulaAluno($registroAula, $aluno);

echo 'TipoUsuario :'.$tipoUsuario;
echo '<br>Usuario :'.$usuario;
echo '<br>Pessoa :'.$pessoa;
echo '<br>Aluno :'.$aluno;
echo '<br>Responsável :'.$responsavel;
echo '<br>Responsável x Aluno :'.$responsavelAluno;
echo '<br>Professor :'.$professor;
echo '<br>Matéria :'.$materia;
echo '<br>SalaVirtual :'.$salaVirtual;
echo '<br>SalaVirtual x Aluno :'.$salaVirtualAluno;
echo '<br>SalaVirtual x Professor :'.$salaVirtualProfessor;
echo '<br>ResigroAula :'.$registroAula;
echo '<br>RegistoAula x Aluno :'.$registroAulaAluno;