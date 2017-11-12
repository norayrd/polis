<?php

namespace AppBundle\Controller;

use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Worksheet_Drawing;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExportXlsController extends Controller
{

    private static $bordersAll = array(
                    'left' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                        ),
                    'right' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                        ),
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                        ),
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                        )
                    );

    private function setBorders($sheet = 0, $cols = array(), $rowNo = 1) {

            foreach ($cols as $col) {
                $cellStyle = $sheet ->getStyle($col.$rowNo);
                $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
            }
    }

    private function setBold($sheet = 0, $cols = array(), $rowNo = 1, $bold = true) {

            foreach ($cols as $col) {
                $cellStyle = $sheet ->getStyle($col.$rowNo);
                $cellStyle ->getFont()->setBold($bold);
            }
    }
            
    /**
     * @Route("/polis-xls", name="polis_xls")
     */
    public function polisXlsAction(Request $request) {
        
        $is_guest = !is_object($this->getUser());

        $polisId = $request ->get("polisid");
        
        $polisService = $this->get("polis_service");

        $polis = $polisService ->getPolis($this->getUser(), $polisId);
        
        // ask the service for a excel object
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        
        $phpExcelObject->getProperties()->setCreator("liuggio")
                ->setLastModifiedBy("")
                ->setTitle("")
                ->setSubject("")
                ->setDescription("")
                ->setKeywords("")
                ->setCategory("");
        
        $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
        
        if (is_object($polis)) {
            
            $arrayAG = array('A','B','C','D','E','F','G');

            foreach ($arrayAG as $val) {
                $activeSheet ->getColumnDimension($val)->setWidth(18,4);
            }

            // header
            // row 5
            $activeSheet ->mergeCells('A5:G5')
                    ->getStyle('A5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                    ->getStartColor()->setRGB('CC99FF');
            $activeSheet ->setCellValue('A5', 'СОБСТВЕННИК');
            $activeSheet ->getStyle('A5') ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
            $this ->setBorders($activeSheet, $arrayAG, 5);
            $this ->setBold($activeSheet, $arrayAG, 5);

            // row 6
            $activeSheet ->setCellValue('A6', 'фамилия');
            $activeSheet ->setCellValue('B6', 'имя');
            $activeSheet ->setCellValue('C6', 'отчество');
            $activeSheet ->setCellValue('D6', 'дата рождения');
            $activeSheet ->setCellValue('E6', 'паспорт серия');
            $activeSheet ->setCellValue('F6', 'паспорт номер');
            $activeSheet ->setCellValue('G6', 'дат.выд.');
            $this ->setBorders($activeSheet, $arrayAG, 6);

            // row 7
            $activeSheet ->setCellValue('A7', $polis->getOwnerSurname());
            $activeSheet ->setCellValue('B7', $polis->getOwnerName());
            $activeSheet ->setCellValue('C7', $polis->getOwnerMiddlename());
            $activeSheet ->setCellValue('D7', $polis->getOwnerBirthday()->format('d.m.Y'));
            $activeSheet ->setCellValue('E7', $polis->getOwnerPaspSerya());
            $activeSheet ->setCellValue('F7', $polis->getOwnerPaspNumber());
            $activeSheet ->setCellValue('G7', $polis->getOwnerPaspDate()->format('d.m.Y'));
            
            $this ->setBorders($activeSheet, $arrayAG, 7);
            $this ->setBold($activeSheet, $arrayAG, 7);

            // row 8
            $activeSheet ->setCellValue('A8', 'прописка');
            $activeSheet ->mergeCells('B8:C8');
            $activeSheet ->setCellValue('B8', $polis->getRegCity() );
            $activeSheet ->mergeCells('D8:E8');
            $activeSheet ->setCellValue('D8', $polis->getRegStateType().' '.$polis->getRegState());
            $activeSheet ->mergeCells('F8:G8');
            $activeSheet ->setCellValue('F8', 
                    $polis->getRegStreet().
                    ', д.'.$polis->getRegNhome().
                    ( ($polis->getRegNflat()) ? ' кв.'.$polis->getRegNflat() : '' )
                    );
            $this ->setBorders($activeSheet, $arrayAG, 8);
            $this ->setBold($activeSheet, array('B','C','D','E','F','G'), 8);

            // row 9
            $activeSheet ->mergeCells('A9:G9')
                    ->getStyle('A9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                    ->getStartColor()->setRGB('CCFFCC');
            $activeSheet ->setCellValue('A9', 'ТРАНСПОРТНОЕ СРЕДСТВО');
            $activeSheet ->getStyle('A9') ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
            $this ->setBorders($activeSheet, $arrayAG, 9);
            $this ->setBold($activeSheet, $arrayAG, 9);

            // row 10
            $activeSheet ->setCellValue('A10', 'кузов');
            $activeSheet ->setCellValue('B10', 'марка/модель');
            $activeSheet ->setCellValue('C10', 'год изготовления');
            $activeSheet ->setCellValue('D10', 'серия ПТС');
            $activeSheet ->setCellValue('E10', 'номер ПТС');
            $activeSheet ->setCellValue('F10', '');
            $activeSheet ->setCellValue('G10', 'дат.выд.');
            $this ->setBorders($activeSheet, $arrayAG, 10);

            // row 11
            $activeSheet ->setCellValue('A11', $polis->getTrVinNumber());
            $activeSheet ->setCellValue('B11', $polis->getTrMake().' / '.$polis->getTrModel());
            $activeSheet ->setCellValue('C11', $polis->getTrYear());
            $activeSheet ->setCellValue('D11', $polis->getTrDocSerya());
            $activeSheet ->setCellValue('E11', $polis->getTrDocNumber());
            $activeSheet ->setCellValue('F11', '');
            $activeSheet ->setCellValue('G11', $polis->getTrDocDate()->format('d.m.Y'));
            $this ->setBorders($activeSheet, $arrayAG, 11);
            $this ->setBold($activeSheet, $arrayAG, 11);

            // row 12
            $activeSheet ->setCellValue('A12', 'л.с.');
            $activeSheet ->setCellValue('B12', $polis->getTrPower());
            $activeSheet ->setCellValue('C12', 'гос номер');
            $activeSheet ->setCellValue('D12', $polis->getTrCarNumber());
            $activeSheet ->getStyle('A12:B12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                    ->getStartColor()->setRGB('00FF00');
            $activeSheet ->getStyle('C12:D12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                    ->getStartColor()->setRGB('FF8080');
            $this ->setBorders($activeSheet, $arrayAG, 12);
            $this ->setBold($activeSheet, array('B','D'), 12);
            
            if ( count($polis->getDrivers())>0 ) {

                // row 13
                $activeSheet ->mergeCells('A13:G13')
                        ->getStyle('A13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                        ->getStartColor()->setRGB('CC99FF');
                $activeSheet ->setCellValue('A13', 'ВОДИТЕЛИ');
                $activeSheet ->getStyle('A13') ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                $this ->setBorders($activeSheet, $arrayAG, 13);
                $this ->setBold($activeSheet, $arrayAG, 13);

                $r = 1;
                foreach ( $polis->getDrivers() as $driver) {

                    $rowNo = 14 + ($r-1)*3;

                    // row 14
                    $activeSheet ->mergeCells('A'.$rowNo.':G'.$rowNo)
                            ->getStyle('A'.$rowNo)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                            ->getStartColor()->setRGB('DDDDDD');
                    $activeSheet ->setCellValue('A'.$rowNo, $r);
                    $activeSheet ->getStyle('A'.$rowNo) ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
                    $this ->setBorders($activeSheet, $arrayAG, $rowNo);
                    $this ->setBold($activeSheet, $arrayAG, $rowNo);

                    // row 15
                    $activeSheet ->setCellValue('A'.($rowNo+1), 'фамилия');
                    $activeSheet ->setCellValue('B'.($rowNo+1), 'имя');
                    $activeSheet ->setCellValue('C'.($rowNo+1), 'отчество');
                    $activeSheet ->setCellValue('D'.($rowNo+1), 'дата рождения');
                    $activeSheet ->setCellValue('E'.($rowNo+1), 'серия в/у');
                    $activeSheet ->setCellValue('F'.($rowNo+1), 'номер в/у');
                    $activeSheet ->setCellValue('G'.($rowNo+1), 'дата начала стажа');
                    $this ->setBorders($activeSheet, $arrayAG, $rowNo+1);

                    // row 16
                    $activeSheet ->setCellValue('A'.($rowNo+2), $driver->getSurname());
                    $activeSheet ->setCellValue('B'.($rowNo+2), $driver->getName());
                    $activeSheet ->setCellValue('C'.($rowNo+2), $driver->getMiddlename());
                    $activeSheet ->setCellValue('D'.($rowNo+2), $driver->getBirthday()->format('d.m.Y'));
                    $activeSheet ->setCellValue('E'.($rowNo+2), $driver->getDocSerya());
                    $activeSheet ->setCellValue('F'.($rowNo+2), $driver->getDocNumber());
                    $activeSheet ->setCellValue('G'.($rowNo+2), $driver->getDocDate()->format('d.m.Y'));
                    $this ->setBorders($activeSheet, $arrayAG, $rowNo+2);
                    $this ->setBold($activeSheet, $arrayAG, $rowNo+2);

                    $r++;
                }

            }
            
            #$activeSheet ->getColumnDimension('B')->setWidth(40);
            #$imagePath = './data/pi.jpg';
            #if (file_exists($imagePath)) {
            #    $logo = new PHPExcel_Worksheet_Drawing();
            #    $logo->setPath($imagePath);
            #    $logo->setCoordinates("B2");             
            #    $logo->setOffsetX(0);
            #    $logo->setOffsetY(0);    
            #    $activeSheet ->getRowDimension(2) ->setRowHeight(190);
            #    $logo->setWorksheet($activeSheet);
            #}

        } else {
            
            $activeSheet ->setCellValue('A1', 'Нет доступа!');
        }
        
        $phpExcelObject->getActiveSheet()->setTitle('polis');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'polis'.$polisId.'.xlsx'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }
}
