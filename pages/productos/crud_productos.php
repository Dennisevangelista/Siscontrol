<?php
  require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
  require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
$fun      =$_POST['funcion'];
$id       =$_POST['id'];
$id_materia=$_POST['codmateria'];
$producto =$_POST['producto'];
$categoria=$_POST['categoria'];
$constante=$_POST['subcat'];
$espesor  =$_POST['espesor'];
$alto     =$_POST['alto'];
$ancho    =$_POST['ancho'];
$precio   =$_POST['precio'];
$compra   =$_POST['compra'];
//var_dump($id_materia);
if ($fun==1){
	
if ($categoria==1) {
$peso = ($espesor * $ancho * $alto * $constante)/1000;	
}else{
$peso = ($espesor * $ancho * $alto * $constante)/1000000;	
}
//echo $peso;die();

	
	$insert="INSERT INTO empp_tb_productos (id_materia,nombre,descripcion,cantidad,id_sub_categoria,id_categoria,codigo_producto,tipo_producto,espesor,precio_compra,precio_venta,alto,ancho,peso,estado) VALUES('$id_materia','$producto','','0','1','$categoria','$id','$constante','$espesor','$compra','$precio','$alto','$ancho','".number_format($peso, 4, '.', ' ')."','1')";
	//echo $insert;die();
	$ejec=mysqli_query($con,$insert);
	

	 if (mysqli_affected_rows($con)!=0) {
		$cot=mysqli_query($con,"SELECT MAX(id_produc) as id  from empp_tb_productos");
	$ids= mysqli_fetch_array($cot);
	$idcreado=$ids['id'];

	$insertinventario="INSERT INTO empp_tb_inventario (id_produc, stock, fecha_mof) VALUES('$idcreado','0',NOW())";
	//echo $insert;die();
	$ejectar=mysqli_query($con,$insertinventario);
	 echo "1";
	 }else{
	 	echo "2";
	 }

}else if ($fun==2) {
	// buscar
	//echo "23";
	$return_arr = array();
	$buscar= mysqli_query($con,"SELECT id_produc,codigo_producto,id_categoria,id_sub_categoria,nombre,estado,espesor,alto,ancho,precio_compra,precio_venta,peso FROM empp_tb_productos WHERE estado='1' and id_produc='$id'");
    	while ($row = mysqli_fetch_array($buscar)) {
		$row_array['idp']=$row['id_produc'];
		$row_array['id']=$row['codigo_producto'];
		$row_array['nombres']=$row['nombre'];
		$row_array['cat']=$row['id_categoria'];
		$row_array['scat']=$row['id_sub_categoria'];
		$row_array['estado']=$row['estado'];
		$row_array['espesor']=$row['espesor'];
		$row_array['alto']=$row['alto'];
		$row_array['ancho']=$row['ancho'];
		$row_array['compra']=$row['precio_compra'];
		$row_array['venta']=$row['precio_venta'];
		array_push($return_arr,$row_array);
    }
   echo json_encode($return_arr);
}else if ($fun==3) {
	// EDITAR
	$peso = $espesor * $ancho * $alto * $constante ;
	try {
	$ed="UPDATE empp_tb_productos SET codigo_producto='$id',nombre='$producto',id_categoria='$categoria',id_sub_categoria='1',espesor='$espesor',alto='$alto',ancho='$ancho',precio_venta='$precio',precio_compra='$compra' , peso ='$peso' WHERE id_produc='$id'";
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
	$ed="UPDATE empp_tb_productos SET estado='0' WHERE id_produc='$id'";
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
else if ($fun==5) {
	$tipo_producto =$_POST['tipo_producto'];
	$constante =$_POST['constante'];	


	$insert="INSERT INTO empp_tb_tipo_producto (tipo_producto,constante,fecha,estado) VALUES('$tipo_producto','$constante',NOW(),'1')";
	echo $insert;die();
	$ejec=mysqli_query($con,$insert);
	
}
?>