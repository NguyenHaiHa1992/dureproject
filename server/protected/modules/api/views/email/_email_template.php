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
                                    <span style="font-family:Arial,Helvetica,san-serif;font-size:10pt"><?php echo $header; ?></span>
                                    <hr>
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center">
                                        <center>
                                            <table style="font-family:Arial,Helvetica,san-serif;font-size:10pt" border="0" cellpadding="2" cellspacing="0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" align="CENTER">
                                                            <img style="width: 200px" src="<?php echo Yii::app()->getBaseUrl(true); ?>/data/images/logo.png"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" align="CENTER" valign="TOP"><font style="font-family:Arial,Helvetica,san-serif;font-size:14pt"><?php echo $name; ?></font>
                                                            <br>
                                                            Address: <?php echo $address; ?>
                                                            <br>
                                                            Email: <a href="mailto:<?php echo $email; ?>" target="_blank"><?php echo $email; ?></a>
                                                            <br>
                                                            Phone: <?php echo $phone; ?>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr valign="TOP">
                                                        <td colspan="2">
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr valign="TOP">
                                                        <td colspan="2" align="RIGHT">Sent by Date: <b><?php echo date('Y-m-d', time()); ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <table style="font-family:Arial,Helvetica,san-serif;font-size:10pt; width: 100%" border="0" cellpadding="2" cellspacing="0">
                                                                                <tbody>
                                                                                    <tr bgcolor="#FEFEFE">
                                                                                        <td style="padding:0">
                                                                                            <?php echo $content; ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <table style="font-family:Arial,Helvetica,san-serif;font-size:10pt" width="100%" bgcolor="#eeeeee" border="0" cellpadding="2" cellspacing="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="font-family:Arial,Helvetica,san-serif;font-size:9pt" align="center">
                                                                                            <a style="text-align: center;display: inline-block;padding: 10px 0px;width: 100px;background: #21629b;margin: 15px;color: #FFF;text-decoration: none;border-radius: 5px" href="<?php echo $link; ?>" target="_blank">
                                                                                                Accept
                                                                                            </a>
                                                                                            <a style="text-align: center;display: inline-block;padding: 10px 0px;width: 100px;background: #FF9B00;margin: 15px;color: #FFF;text-decoration: none;border-radius: 5px" href="<?php echo $decline_link; ?>" target="_blank">
                                                                                                Decline
                                                                                            </a>
                                                                                            <br />
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
<tr>
    <td align="CENTER">
        <p style="text-align: center; font-size: 12px;">AM Precision - Address: 153 Sugar Maple Rd, St George Brant, ON Canada N0E 1N0 - Phone: (519) 448-1311 - Email: office@amprecision.ca</p>
    </td>
</tr>
</tbody>
</table>
</div>