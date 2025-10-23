<?php
include("../Php/connection.php");
include("../Php/verify.php");

$id_login = $_SESSION['cpf'];

$sql_Perfil = "SELECT id_Perfil FROM Perfil WHERE cpf_usuario = $id_login";
$res_Perfil = mysqli_query($id, $sql_Perfil);

$result_perfil = mysqli_fetch_array( $res_Perfil );

$idPerfil = $result_perfil['id_Perfil'];

$treino = isset($_POST['searchBar']) ? $_POST['searchBar'] : '';

if(!empty($treino)){
    $pesc_treino = "%" . $treino . "%";

        $sql_pesquisa = "SELECT id_treino, nome, data_criacao, duracao, imagem 
                        FROM treino_personalizado 
                        WHERE nome LIKE '$pesc_treino' 
                        AND id_Perfil = $idPerfil
                        LIMIT 10";
        
        $result_treino = mysqli_query($id, $sql_pesquisa);

        $row_count = mysqli_num_rows($result_treino);

        if($row_count > 0){ 
            $dados = array();
            while($row_produto = $result_treino->fetch_assoc()){
                $dados[] = [
                    "id_treino" => $row_produto['id_treino'],
                    "nome" => $row_produto['nome'],
                    "data_criacao" => $row_produto['data_criacao'],
                    "duracao" => $row_produto['duracao'],
                    "imagem" => $row_produto['imagem']
                ];
            }
            $return = ['status' => true, 'dados' => $dados];
        } else {
            $return = ['status' => false, 'msg' => 'Nenhum treino encontrado!'];
        }
    } else {
    $return = ['status' => false, 'msg' => 'Digite algo para pesquisar!'];
    }

echo json_encode($return);
exit;
?>