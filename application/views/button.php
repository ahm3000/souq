<?php
$btn_text = '';

switch ($btn_type){
	case "list":
		$btn_icon = "fa fa-list";
		$btn_class = "btn btn-info";
		break;
	case "view":
		$btn_icon = "fa fa-eye";
		$btn_class = "btn btn-info";
		break;
	case "edit":
		$btn_icon = "fa fa-edit";
		$btn_class = "btn btn-default";
		break;
	case "delete":
		$btn_icon = "fa fa-trash-o";
		$btn_class = "btn btn-danger";
		break;
	case "apply":
		$btn_icon = "fa fa-check";
		$btn_class = "btn btn-danger";
		$btn_text = 'اعتماد الطلبات وإيقاف المنتج';
		break;
	case "applyone":
		$btn_icon = "fa fa-check";
		$btn_class = "btn btn-danger";
// 		$btn_text = 'اعتماد الطلبات وإيقاف المنتج';
		break;
	default:
		break;
}
?>
<a class="<?php echo $btn_class;?>" href="<?php echo $url;?>"><i class="<?php echo $btn_icon;?>"></i> <?=$btn_text;?></a>
