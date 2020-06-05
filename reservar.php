<?php
require 'config.php';
require 'classes/reservas.class.php';
require 'classes/carros.class.php';

$reservas = new reservas($pdo);
$carros = new carros($pdo);

if(!empty($_POST['carro'])){
    $carro = addslashes($_POST['carro']);
    $data_inicio = explode('/', addslashes($_POST['data_inicio']));
    $data_fim = explode('/', addslashes($_POST['data_fim']));
    $nome = addslashes($_POST['nome']);

    $data_inicio = $data_inicio[2]."-".$data_inicio[1]."-".$data_inicio[0];
    $data_fim = $data_fim[2]."-".$data_fim[1]."-".$data_fim[0];


    if($reservas->verificarDisponibilidade($carro,$data_fim,$data_inicio)){
        $reservas->reservar($carro,$data_inicio,$data_fim,$nome);
        header("location:index.php");
    }else{
        echo "ESSE CARRO JÁ ESTÁ RESERVADO NESSE PERIODO";
    }

}



?>

<h1>ADICIONAR RESERVA</h1>

<form method="POST">

    Carro:<br>
    <select name="carro">
        <?php
            $lista = $carros->getCarros();
            foreach($lista as $carro):
                ?>
                <option value="<?php echo $carro['id']; ?>"><?php echo $carro['nome']; ?></option>
            <?php
            
            endforeach;
        ?>
    </select><br>
    Data inicio:<br>
    <input type="text" name="data_inicio"><br>
    Data fim:<br>
    <input type="text" name="data_fim"><br>

    Nome:<br>
    <input type="text" name="nome"><br><br>

    <input type="submit" value="Reservar">

</form>