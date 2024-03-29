<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ficha extends CI_Controller {



	function __construct() {
		parent::__construct();
		if ($this -> session -> userdata('logged_in')) {
			$this -> sessaoUsuario = $this -> session -> userdata('logged_in');
		} else {
			redirect('login');
		}

	}

	public function index() {
		$this -> load -> view('ficha');
	}
	

	function unico_jovem($id){
		$this -> load -> model('jovem_model');
		$jovem = $this->jovem_model->listarUnicoJovemID($id);
		return $jovem;

	}

	function listaMinisterioJovem($id)
	{
		$this->load->model('ministerio_model');
		$participa = $this->ministerio_model->listarMinisteriosDoJovem($id);
		return $participa;

	}
	/* 
	 * Listar Categorias
	 * 
	 * Teste = OK
	 */
	function imprimir($id) {
		//$this -> load -> view('ficha');
		if (!$id) {
			redirect('ficha'); 
		}

		$dados = $this->unico_jovem($id);
		$participa = $this-> listaMinisterioJovem($id);
		$texto = "";

		foreach ($participa as $row) {
			$ministerios[] = $row->nome;
		};
		if ($participa) {
			$texto = join(", ", $ministerios);
		}
		
		if (!$dados[0]) {
			redirect('ficha'); 
		}
		echo" 



<!doctype html>
<html>
<head>
	<title>Ficha de Cadastro  do Jovem - MJRBH</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	 <style>
                @media print { 
                    #noprint { display:none; } 
                    header { display: none; }
  }					footer { display: none; }
                    body { background: #fff; }
                }
     </style>

</head>
<body>
<h1><span style='font-size:22px'>Ficha de Cadastro Jovem - MJRBH</span></h1>

<p><strong>Nome:</strong> " . $dados[0]->Nome  . " </p>


<p><strong>Data de Nascimento: </strong> " .  date("d/m/Y", strtotime($dados[0]->DatNasc))  . " </p>


<p><strong>Nome do Pai:</strong> ". $dados[0]->NomePai ."</p> 


<p><strong>Nome da M&atilde;e:</strong>  " . $dados[0]->NomeMae . "</p>


<p><strong>Telefone: </strong> " . $dados[0]->Telefone . "</p> 


<p><strong>Celular:</strong> " . $dados[0]->Celular . "</p>


<p><strong>Email: </strong> " . $dados[0]->Email. "</p>


<p><strong>Endere&ccedil;o:</strong> " . $dados[0]->Endereco . "</p>


<p><strong>RG:</strong> " . $dados[0]->RG . "</p>


<p><strong>Igreja:</strong> ". $dados[0]->Nome_Sede ."</p> 


<p><strong>Minist&eacute;rios:</strong> ". $texto . " </p>


<p><strong>Observa&ccedil;&otilde;es:</strong> " . $dados[0]->Obs . "</p>

<p>&nbsp;</p>

 <div id='noprint'>
<input type='button' name='imprimir' id='imprimir' value='Imprimir' onclick='window.print();''>
</div>

</body>
</html>"
;

	}
}