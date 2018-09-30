<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style></style>
    </head>
    <body>

<table border="0" cellpadding="0" cellspacing="0"  width="600" id="bodyTable" align="center" style="margin:0 auto;">
    <tr>
        <td align="center" valign="top">
            <table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">
                <tr>
                    <td align="center" valign="top" style="background:#486d97;">
                        <table border="0"  width="100%" align="left">
                            <tr>
                                <td align="center" valign="top" style="font-family:arial;font-weight:bold;font-size:18px;color:#FFF;">
                                    Commande Expédiée
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" id="emailBody">
                            <tr>
                                <td align="left" valign="top" style="font-family:arial;font-size:14px;color:#000;">
                                    Votre commande est expédiée. En voici les détails<br /><br />Voici votre numéro de suivi: <?php echo $order->tracking; ?><br /><br />Vous pouvez suivre votre colis sur <a href="http://www.laposte.fr/particulier/outils/suivre-vos-envois">Suivre votre colis</a>.<br /><span style="font-weight:bold;">Veuillez noter qu'un délai de 24h est nécessaire pour que votre numéro de suivi soit activé.</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" id="emailBody">
                            <tr>
                                <td align="left" valign="top" style="font-family:arial;font-weight:bold;font-size:18px;color:#000;text-transform:uppercase;">
                                    Commande : <?php echo $order->id; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" style="border:1px solid #ccc;">
                          <tr>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:bold;font-size:14px;color:#000;text-transform:uppercase;border-right:1px solid #ccc;" align="left">Produit</th>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:bold;font-size:14px;color:#000;text-transform:uppercase;border-right:1px solid #ccc;" align="left">Quantité</th>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:bold;font-size:14px;color:#000;text-transform:uppercase;" align="left">Prix</th>
                          </tr>
                          @foreach($order->lines as $line)
                            <tr>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;border-right:1px solid #ccc;border-top:1px solid #ccc;" align="left"><?php echo $line->name; ?></th>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;border-right:1px solid #ccc;border-top:1px solid #ccc;" align="left"><?php echo $line->quantity; ?></th>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;border-top:1px solid #ccc;" align="left"><?php echo my_format(httottc($line->total_price())); ?>€</th>
                            </tr>
                          @endforeach
                         
                        </table>
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" style="margin:20px 0 0 0;">
                          <tr>
                            <th style="padding:5px 0 5px 20px;width:66.66%;font-family:arial;font-weight:bold;font-size:14px;color:#000;text-transform:uppercase;border-left:1px solid #ccc;border-bottom:1px solid #ccc;border-top:1px solid #ccc;" align="left">Livraison</th>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;border-left:1px solid #ccc;border-bottom:1px solid #ccc;border-top:1px solid #ccc;border-right:1px solid #ccc;" align="left"><?php echo my_format(($order->total_shipping)); ?>€</th>
                          </tr>
                          <tr>
                            <th style="padding:5px 0 5px 20px;width:66.66%;font-family:arial;font-weight:bold;font-size:14px;color:#000;text-transform:uppercase;border-left:1px solid #ccc;border-bottom:1px solid #ccc;" align="left">Montant</th>
                            <th style="padding:5px 0 5px 20px;width:33.33%;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;border-left:1px solid #ccc;border-bottom:1px solid #ccc;border-right:1px solid #ccc;" align="left"><?php echo my_format(($order->total_products + $order->total_shipping)); ?>€</th>
                          </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" id="emailBody">
                            <tr>
                                <td align="left" valign="top" style="padding:5px 0 5px 20px;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;">
                                    <strong style="font-weight:bold;">Coordonnées du client</strong><br /><br /><?php echo $order->billing_first_name; ?><br /><?php echo $order->billing_last_name; ?><br /><?php echo $order->email; ?><br /><?php echo $order->billing_phone; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" id="emailBody">
                            <tr>
                            <th style="padding:5px 0 5px 20px;width:50%;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;border-right:1px solid #ccc;" align="left"><strong style="font-weight:bold;">Adresse de facturation</strong><br /><br /><?php echo $order->billing_address; ?><br /><?php echo $order->billing_city; ?><br /><?php echo $order->billing_country; ?><br /><?php echo $order->billing_zip; ?></th>
                            <th style="padding:5px 0 5px 20px;width:50%;font-family:arial;font-weight:normal;font-size:14px;color:#000;text-transform:uppercase;" align="left"><strong>Adresse de livraison</strong><br /><br /><?php echo $order->shipping_address; ?><br /><?php echo $order->shipping_city; ?><br /><?php echo $order->shipping_country; ?><br /><?php echo $order->shipping_zip; ?></th>
                          </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" id="emailBody">
                            <tr>
                                <td align="left" valign="top" style="font-family:arial;font-size:14px;color:#000;">
                                    Les informations, données, ainsi que les fichiers joints contenus dans ce courriel sont strictement réservés à l'usage de la personne ou de l'entité à qui il est adressé. La diffusion, la distribution et / ou la copie du document transmis par toute personne autre que le destinataire est interdite, conformément à loi des protections des données ainsi ainsi qu'au règlement (UE) 2016/679. Si vous avez reçu ce courriel par erreur, veuillez nous en aviser immédiatement, détruire toutes les copies et le supprimer de votre système informatique.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
