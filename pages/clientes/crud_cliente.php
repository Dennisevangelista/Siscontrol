<?php
  require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
$fun   =$_POST['funcion'];
$id    =$_POST['id'];
$ruc   =$_POST['ruc'];
$social=$_POST['social'];
$dir   =$_POST['dir'];
$telef =$_POST['telef'];
//echo "llegue";
if ($fun==1){
	//INSERTAR
	$insert="INSERT INTO empp_tb_cliente (tipo_doc,n_doc,nombres,fecha_reg,estado,direccion,telefono) VALUES('1','$ruc','$social',NOW(),'1','$dir','$telef')";
	$ejec=mysqli_query($con,$insert);
	 if (mysqli_affected_rows($con)!=0) {
	 echo "1";
	 }else{
	 	echo "2";
	 }

}else if ($fun==2) {
	// buscar
	$return_arr = array();
	$buscar= mysqli_query($con,"SELECT id_reg,n_doc,nombres,estado,direccion,telefono FROM empp_tb_cliente WHERE estado='1' and id_reg='$id'");
    	while ($row = mysqli_fetch_array($buscar)) {
		$row_array['id']=$row['id_reg'];
		$row_array['nombres']=$row['nombres'];
		$row_array['doc']=$row['n_doc'];
		$row_array['dir']=$row['direccion'];
		$row_array['telef']=$row['telefono'];
		array_push($return_arr,$row_array);
    }
   echo json_encode($return_arr);
}else if ($fun==3) {
	// EDITAR
	try {
	$ed="UPDATE empp_tb_cliente SET n_doc='$ruc',nombres='$social',direccion='$dir',telefono='$telef' WHERE id_reg='$id'";
	$exec= mysqli_query($con,$ed);
	//echo $exec;
	 if (mysqli_affected_rows($con)!=0) {
	 echo "1";
	 }else{
	 	echo "2";
	 }
	} catch (Exception $e) {
        echo "2";		
	}
}else if ($fun==4) {
	// ELIMINAR
	try {
	$ed="UPDATE empp_tb_cliente SET estado='0' WHERE id_reg='$id'";
	$exec= mysqli_query($con,$ed);
	 if (mysqli_affected_rows($con)!=0) {
	 echo "1";
	 }else{
	 	echo "2";
	 }
	} catch (Exception $e) {
        echo "2";		
	}
}
?>