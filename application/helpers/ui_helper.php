<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    function form_group($input, $value, $horizontal = false, $required = false)
    {
        $css_label = "";
        $css_input = "";
        $asterix = (isset($required) && $required) ? "*" : "";

        if ($horizontal) {
            $css_label = "col-sm-2 col-xs-6 control-label";
            $css_input = "col-sm-4 col-xs-10";
        }

        $form_group = "
          <div class='form-group'>
            <label for='".$value['name']."' class='".$css_label."'>".$value['label']." ".$asterix."</label>
            <div class='".$css_input."'>".$input."</div>
          </div>";

        return $form_group;
    }

    function input_text($value, $horizontal = false)
    {
        $disabled = isset($value['disabled']) ? 
            ($value['disabled'] ? 'disabled' : '') 
            : '';
        $type = isset($value["type"]) ? $value["type"] : "text";
        $currentValue = isset($value["value"]) ? $value["value"] : "";
        $required = isset($value["required"]) ? "required" : "";
        $class = isset($value["class"]) ? $value["class"] : "";

        $input = "<input 
          type='".$type."' 
          class='form-control ".$class."' 
          name='".$value['name']."' 
          id='".$value['name']."' 
          placeholder='".$value['label']."'
          value='".$currentValue."'
                ".$disabled."
                ".$required."
        ><span class='help-block' style='display: none;'><span>";
        $input_container = form_group($input, $value, $horizontal, $required);

        return $input_container;
    }

    function input_select($value, $horizontal = false)
    {
        $disabled = isset($value['disabled']) ? 
            ($value['disabled'] ? 'disabled' : '') 
            : '';
        $required = isset($value["required"]) ? "required" : "";

        $input = "<select 
                    id='".$value['name']."' 
                    name='".$value['name']."'
                    class='form-control select2' 
                    style='width: 100%;'
                    " . $disabled . "
                    " . $required . "
                  >
                    <option value='' disabled='' selected=''>Silahkan Pilih</option>";

        foreach ($value['list'] as $val) {
          if (is_array($val)) {
            if (isset($value["selected_value"]) && $val['id'] == $value["selected_value"]) {
                $input .= "<option value='".$val['id']."' selected>".$val['name']."</option>";
            } else {
                $input .= "<option value='".$val['id']."'>".$val['name']."</option>";
            }
          } else {
            if (isset($value["selected_value"]) && strtolower($val) == strtolower($value["selected_value"])) {
                $input .= "<option value='".strtolower($val)."' selected>".$val."</option>";
            } else {
                $input .= "<option value='".strtolower($val)."' >".$val."</option>";
            }
          }
        }

        $input .= "</select><span class='help-block' style='display: none;'><span>";
        $input_container = form_group($input, $value, $horizontal, $required);

        return $input_container;
    }

    function input_hidden($value)
    {
        $input = "<input 
          type='hidden' 
          name='".$value."' 
          id='".$value."' 
        >";

        return $input;
    }

    // page header 
    function page_header($title) {
        $page_header = '
            <section class="content-header">
              <h1>' .$title .'</h1>
              <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                <li class="active"><a href="#">' .$title .'</a></li>
              </ol>
            </section>
        ';

        return $page_header;
    }

    function alert_message($form_message, $session)
    {
        $alert_message = '';
        if (isset($form_message)) {
            $alert_message = <<<HTML
                <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                    $form_message
                </div>
            HTML;
            $session->unset_userdata('form_message'); 
        }

      return $alert_message;
    }

    function alert_danger_message($form_message, $session)
    {
        $alert_danger_message = '';
        if (isset($form_message)) {
            $alert_danger_message = <<<HTML
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-close"></i> Gagal!</h4>
                $form_message
              </div>
            HTML;
            $session->unset_userdata('form_message'); 
        }

      return $alert_danger_message;
    }


?>

       
