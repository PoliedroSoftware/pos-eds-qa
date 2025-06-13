<style id="styles" type="text/css">
<?php 
$template_id = get_preference('receipt_template') ? get_preference('receipt_template') : 1;
echo html_entity_decode(get_the_postemplate($template_id,'template_css'));
?>
</style>
<?php
include DIR_VENDOR.'parser/lex/lib/Lex/ArrayableInterface.php';
include DIR_VENDOR.'parser/lex/lib/Lex/ArrayableObjectExample.php';
include DIR_VENDOR.'parser/lex/lib/Lex/Parser.php';
include DIR_VENDOR.'parser/lex/lib/Lex/ParsingException.php';
$data = get_postemplate_data($invoice_id);
$parser = new Lex\Parser();
$template = html_entity_decode(get_the_postemplate($template_id,'template_content'));
echo $parser->parse($template, $data);
?>

<div class="table-responsive footer-actions">
  <table class="table">
    <tbody>
      <tr class="no-print">
        <td>
          <button  class="btn btn-danger btn-block" id="imprimir">
            <span class="fa fa-fw fa-print"></span> 
            <?php echo trans('pdf'); ?>
          </button>
        </td>
        <td>
          <button onClick="window.printContent('invoice', {title:'<?php echo $invoice_id;?>',scrrenSize:'halfScreen'});" class="btn btn-info btn-block">
            <span class="fa fa-fw fa-print"></span> 
            <?php echo trans('button_print'); ?>
          </button>
        </td>
      </tr>
      <?php if ((user_group_id() == 1 || has_permission('access', 'sms_sell_invoice')) && get_preference('sms_alert')):?>
        <tr class="no-print">
          <td colspan="2">
            <button id="sms-btn" data-invoiceid="<?php echo $invoice_id; ?>" class="btn btn-danger btn-block">
              <span class="fa fa-fw fa-comment-o"></span> 
              <?php echo trans('button_send_sms'); ?>
            </button>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ((user_group_id() == 1 || has_permission('access', 'email_sell_invoice'))):?>
        <tr class="no-print">
          <td colspan="2">
            <button id="email-btn" data-customerName="<?php echo $invoice_info['customer_name']; ?>" data-invoiceid="<?php echo $invoice_id;?>" class="btn btn-success btn-block">
              <span class="fa fa-fw fa-envelope-o"></span> 
              <?php echo trans('button_send_email'); ?>
            </button>
          </td>
        </tr>
      <?php endif;?>
      <tr class="no-print">
        <td colspan="2">
          <a class="btn btn-default btn-block" href="pos.php">
            &larr; <?php echo trans('button_back_to_pos'); ?>
          </a>
        </td>
      </tr>
      <tr class="text-center">
        <td colspan="2">
          <br>
          <p class="powered-by">
            <small>&copy; Poliedro Software S.A.S</small>
          </p>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<script>
    $('#imprimir').click(function(){
        htmlFactura = btoa($('section.receipt-template').html()
                .replace("ñ","n").replace("N°","N")
                .replace("<img","<img width='80' height='80' style='width:80px'")
                .replace("1_logo.png","1_favicon.png")
                .replace('"logo-area"','"logo-area" style="text-align:center"')
                .replace('class="address-area"','class="address-area" style="font-size:12px;text-align:center;"')
                .replace('<table>','<table style="font-size:10px">')
                .replace('<table>','<table style="font-size:10px">')
                .replace('<table>','<table style="font-size:10px">')
                .replace('class="main-title"','class="main-title" style="font-size:10px;font-weight:700"')
                .replace('class="store-name"','class="store-name" style="font-size:10px;font-weight:700;text-align:center;"')
                .replace('class="receipt-header"','class="receipt-header" style="font-size:12px;font-weight:700;text-align: center;"')
                .replace('</span>',`</span ><br>\n`)
                .replace('</span>','</span ><br>\n')
                .replace('</span>','</span ><br>\n')
                .replace('</span>','</span ><br>\n')
                .replace('</span>','</span ><br>\n')
                );
//        htmlFactura = 
        console.log(htmlFactura);
        form = "<form target='blank' method='post' id='frmFactura' action='../pdf/pdfFactura.php'>";
        form += "<input type='hidden' name='html' value='"+htmlFactura+"'>";
        form += "</form>";
        $('body').append(form);
        
        $('#frmFactura').submit();
        
//        window.open("../pdf/pdfFactura.php?html="+htmlFactura, "Diseño Web", "width=300, height=200")
//                $('#cargaPdf').load( "../pdf/pdfFactura.php", {html : htmlFactura},function() {
//                    
//                })
    })
</script>