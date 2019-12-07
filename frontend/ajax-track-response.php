<?php
include "../lib/UPS.php";
include "config.php";

$trackingNumber = trim($_REQUEST['trackingnumber']);

if (empty($trackingNumber)) {
    echo "Error: Tracking number is empty.";
    die;
}

try {

    $ups = new UPS\UPSClient($keyaccess, $userid, $passwd, $mode);
    $resp = $ups->track($trackingNumber);


    if (is_object($resp)) {

        $html = '<table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th colspan="7">Shipment Summary</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td scope="row">Tracking:</td>
                                <td>'.$trackingNumber.'</td>
                                <td>Service:</td>
                                <td>'.$resp->Shipment->Service->Description.'</td>
                            </tr>
                            <tr>
                                <td scope="row">Shipment Type: </td>
                                <td>'.$resp->Shipment->ShipmentType->Description.'</td>
                                <td>Reference:</td>
                                <td>'.$resp->Shipment->ReferenceNumber->Value.'</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold" colspan="7">Shipment Activity</td>
                            </tr>';

                            foreach($resp->Shipment->Package->Activity as $activity){
                                $html .='<tr>
                                            <td colspan="2">
                                            '.date("M d, Y G:i",strtotime($activity->Date.' '.$activity->Time)).'
                                            </td>
                                            <td colspan="5">
                                            '.$activity->Status->Description.'
                                            </td>
                                        </tr>';
                            }


            $html .= '</tbody>
                </thead>
                </table>';

        echo $html;
    }



} catch (\Exception $e) {

    echo "Error: " . $e->getMessage();
}
