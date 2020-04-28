<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class grafico_barras {
    
 
    function cargar() {
        include(APPPATH.'third_party/grafi_barras/jpgraph.php');
        include(APPPATH.'third_party/grafi_barras/jpgraph_bar.php');
         //return new  phpCode128("hola mundo", 150, false, 18);
        
        //return new Graph(350, 250, "auto");
        
    }
}

?>