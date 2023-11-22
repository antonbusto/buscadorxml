<?php
//buscarv.php
//nuevo objeto DOM para procesar el XML
$xmlDoc=new DOMDocument();
//leer el archivo en el objeto
$xmlDoc->load("paginas.xml");
//localizar los elementos <link> en el objeto xml
$x=$xmlDoc->getElementsByTagName('link');
//recoger el parámetro enviado
$q=$_GET["q"];

//buscar elementos en el objeto xml 
if (strlen($q)>0) {
  $pista=""; 
  for($i=0; $i<($x->length); $i++) {
    $y=$x->item($i)->getElementsByTagName('title');
    $z=$x->item($i)->getElementsByTagName('url');
    if ($y->item(0)->nodeType==1) { 
    /* encontrar nodo de tipo elemento (1) que coincida con el texto de búsqueda, si coincide hacemos el enlace. Los enlaces podrían cargar con target='_blank' */
    if (stristr($y->item(0)->childNodes->item(0)->nodeValue, $q)) { //stristr para buscar la primera aparición
	//buscar todas las apariciones
        if ($pista=="") {
          $pista="<a href='" .
          $z->item(0)->childNodes->item(0)->nodeValue .
          "'>" .
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        } else {
          $pista=$pista . "<br /><a href='" .
          $z->item(0)->childNodes->item(0)->nodeValue .
          "'>" .
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        }
      }
    }
  }
}

// Informar si no se encuentra coincidencia
if ($pista=="") {
  $respuesta="No hay sugerencias";
} else {
  $respuesta=$pista;
}
//imprimir la respuesta
echo $respuesta;
?>