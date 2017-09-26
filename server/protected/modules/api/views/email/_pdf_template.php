<div style="color:#000;width: 100%;">
    <span class="HOEnZb"><font color="#888888"></font></span>
    <table style="margin:0 auto; width: 100%">
        <tbody>
            <tr>
                <td align="CENTER">
                    <table border="0" cellpadding="10" cellspacing="0" width="100%" style="background: #FFF">
                        <tbody>
                            <tr>
                                <td>
                                    <span style="font-family:Arial, Helvetica,san-serif;font-size:10pt"></span>
                                    <hr>
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center">
                                        <center>
                                            <table style="font-family:Arial, Helvetica,san-serif;font-size:10pt; color: #26327a;" border="0" cellpadding="2" cellspacing="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" align="CENTER">
                                                            <img style="width: 400px" src="<?=DOMAIN_NAME?>/amp/images/pdf_logo.png"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="CENTER" valign="TOP"><font style="font-family:Helvetica,san-serif;font-size:14pt"></font>
                                                            <br>
                                                            Address: <?= CustomEnum::COMPANY_ADDRESS ?> 
                                                            <br>
                                                            Email: <a href="mailto:<?= CustomEnum::COMPANY_EMAIL ?>" target="_blank"><?= CustomEnum::COMPANY_EMAIL ?></a>
                                                            <br>
                                                            Phone: <?= CustomEnum::COMPANY_PHONE ?>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr valign="TOP">
                                                        <td colspan="2">
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr valign="TOP">
                                                        <td colspan="2" align="RIGHT" style="text-align: right; color: #26327a; font-size: 9pt;">Sent by Date: <b><?php echo date('Y-m-d', time()); ?></b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</td>
</tr>
</table>
    
<?php echo $content; ?>
    
<table>
<tr>
    <td align="CENTER">
        <hr/>
        <p style="text-align: center; font-size: 9pt; color: #26327a;">M&M Food Market - Address: <?= CustomEnum::COMPANY_ADDRESS ?> - Phone: <?= CustomEnum::COMPANY_PHONE ?> - Email: <?= CustomEnum::COMPANY_EMAIL ?></p>
    </td>
</tr>
</tbody>
</table>
</div>