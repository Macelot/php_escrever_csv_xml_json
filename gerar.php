<?php
//CSV
//fonte: https://www.php.net/manual/pt_BR/function.fputcsv.php
//criando o conjunto de valores a ser gravado
$lista = array (
    array('Nome', 'Telefone', 'Endereço'),
    array('Pessoa1', '456', 'Rua XXX'),
    array('Pessoa2', '789', 'Rua yyy')
);
//definindo o nome do arquivo e abrindo o mesmo para escrita (write)
$fp = fopen("contatos.csv", 'w');
//percorrendo o conjunto de valores e gravando no arquivo
foreach ($lista as $linha) {
    fputcsv($fp, $linha,";");
}
//fechando o arquivo
fclose($fp);

//XML
//fonte
//https://pt.stackoverflow.com/questions/99967/como-gerar-um-arquivo-xml-%C3%A0-partir-de-um-formul%C3%A1rio-em-php
//definindo a versao do encoding xml
$dom = new DOMDocument("1.0", "UTF-8");
//retirando os espacos em branco
$dom->preserveWhiteSpace = false;
//gerarando o codigo
$dom->formatOutput = true;
//criando o nó principal (root)
$root = $dom->createElement("agenda");

$lin=0;
foreach ($lista as $linha) {
	if ($lin>0){
		//nó filho (contato)
		$contato = $dom->createElement("contato");
		//setanto nomes e atributos dos elementos xml (nós)
		$nome = $dom->createElement($lista[0][0], $linha[0]);
		$telefone = $dom->createElement($lista[0][1], $linha[1]);
		$endereco = $dom->createElement($lista[0][2], $linha[2]);
		//adiciona os nós (informacaoes do contato) em contato
		$contato->appendChild($nome);
		$contato->appendChild($telefone);
		$contato->appendChild($endereco);
		$root->appendChild($contato);
		//adiciona o nó contato em (root) agenda
		$dom->appendChild($root);
	}
	$lin++;
}
// salvando o arquivo
$dom->save("contatos.xml");

//JSON
//https://blog-en.openalfa.com/how-to-read-and-write-json-files-in-php
//https://stackoverflow.com/questions/3281354/create-json-object-the-correct-way
//criando o array que vai conter os dados dos contatos
$json = array();
$lin=0;
foreach ($lista as $linha) {
	if ($lin==0){
		$key = $linha;
	}else{
		$json[] = array_combine($key, $linha);
	}
	$lin++;
}
//criando o conjunto de contatos
$contatos = array ('conato' => $json);
//alocando os contatos no array agenda
$agenda = array('agenda' => $contatos);
//definido o arquivo resultante
$fh = fopen("contatos.json", 'w');
//salvando o arquivo 
fwrite($fh, json_encode($agenda,JSON_UNESCAPED_UNICODE));
//fechando o arquivo
fclose($fh);

//conversão online
//http://www.utilities-online.info/xmltojson
//validação online JSON
//https://jsonlint.com/

?>