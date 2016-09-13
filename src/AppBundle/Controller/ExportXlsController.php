<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Worksheet_Drawing;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Controller used to manage the application security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class ExportXlsController extends Controller
{

    public static $bordersAll = array(
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


    /**
     * @Route("/polis-xls", name="polis_xls")
     */
    public function polisXlsAction(Request $request) {
        
        $is_guest = !is_object($this->getUser());

        $polisId = $request ->get("polisid");

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
        
        foreach (array('A','B','C','D','E','F','G') as $val) {
            $activeSheet ->getColumnDimension($val)->setWidth(18,4);
        }
        
        // header
        // row 5
        $activeSheet ->mergeCells('A5:G5')
                ->getStyle('A5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                ->getStartColor()->setRGB('CC99FF');
        $activeSheet ->setCellValue('A5', 'СОБСТВЕННИК');
        $activeSheet ->getStyle('A5') ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $activeSheet ->getStyle('A5') ->getFont()->setBold(true);
        $activeSheet ->getStyle('A5:G5') ->getBorders() ->applyFromArray( self::$bordersAll );
        
        // row 6
        $activeSheet ->setCellValue('A6', 'фамилия');
        $activeSheet ->setCellValue('B6', 'имя');
        $activeSheet ->setCellValue('C6', 'отчество');
        $activeSheet ->setCellValue('D6', 'дата рождения');
        $activeSheet ->setCellValue('E6', 'паспорт серия');
        $activeSheet ->setCellValue('F6', 'паспорт номер');
        $activeSheet ->setCellValue('G6', 'дат.выд.');
        
        foreach (array('A','B','C','D','E','F','G') as $val) {
            $cellStyle = $activeSheet ->getStyle($val.'6');
            $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
        }

        // row 7
        $activeSheet ->setCellValue('A7', 'Полищук');
        $activeSheet ->setCellValue('B7', 'Артем');
        $activeSheet ->setCellValue('C7', 'Викторович');
        $activeSheet ->setCellValue('D7', '29.06.1970');
        $activeSheet ->setCellValue('E7', '2325');
        $activeSheet ->setCellValue('F7', '256487');
        $activeSheet ->setCellValue('G7', '12.05.2012');

        foreach (array('A','B','C','D','E','F','G') as $val) {
            $cellStyle = $activeSheet ->getStyle($val.'7');
            $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
            $cellStyle ->getFont()->setBold(true);
        }
        
        // row 8
        $activeSheet ->setCellValue('A8', 'Нефтеюганск');
        $activeSheet ->mergeCells('B8:C8');
        $activeSheet ->setCellValue('B8', '');
        $activeSheet ->mergeCells('D8:E8');
        $activeSheet ->setCellValue('D8', '');
        $activeSheet ->mergeCells('F8:G8');
        $activeSheet ->setCellValue('F8', 'пре. Апанасенко,д.5 кв.12');

        foreach (array('A','B','C','D','E','F','G') as $val) {
            $cellStyle = $activeSheet ->getStyle($val.'8');
            $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
            $cellStyle ->getFont()->setBold(true);
        }
        
        // row 9
        $activeSheet ->mergeCells('A9:G9')
                ->getStyle('A9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                ->getStartColor()->setRGB('CCFFCC');
        $activeSheet ->setCellValue('A9', 'ТРАНСПОРТНОЕ СРЕДСТВО');
        $activeSheet ->getStyle('A9') ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $activeSheet ->getStyle('A9') ->getFont()->setBold(true);
        $activeSheet ->getStyle('A9:G9') ->getBorders() ->applyFromArray( self::$bordersAll );
        
        // row 10
        $activeSheet ->setCellValue('A10', 'кузов');
        $activeSheet ->setCellValue('B10', 'марка/модель');
        $activeSheet ->setCellValue('C10', 'год изготовления');
        $activeSheet ->setCellValue('D10', 'серия ПТС');
        $activeSheet ->setCellValue('E10', 'номер ПТС');
        $activeSheet ->setCellValue('F10', '');
        $activeSheet ->setCellValue('G10', 'дат.выд.');
        
        foreach (array('A','B','C','D','E','F','G') as $val) {
            $cellStyle = $activeSheet ->getStyle($val.'10');
            $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
        }

        // row 11
        $activeSheet ->setCellValue('A11', 'XTA21102030592853');
        $activeSheet ->setCellValue('B11', 'Ваз2107');
        $activeSheet ->setCellValue('C11', '1990');
        $activeSheet ->setCellValue('D11', '2325');
        $activeSheet ->setCellValue('E11', '256458');
        $activeSheet ->setCellValue('F11', '');
        $activeSheet ->setCellValue('G11', '26071990');

        foreach (array('A','B','C','D','E','F','G') as $val) {
            $cellStyle = $activeSheet ->getStyle($val.'11');
            $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
            $cellStyle ->getFont()->setBold(true);
        }
        
        // row 12
        $activeSheet ->setCellValue('A12', 'л.с.');
        $activeSheet ->setCellValue('B12', '72');
        $activeSheet ->setCellValue('C12', 'гос номер');
        $activeSheet ->setCellValue('D12', 'м036от31');
        $activeSheet ->getStyle('A12:B12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                ->getStartColor()->setRGB('00FF00');
        $activeSheet ->getStyle('C12:D12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                ->getStartColor()->setRGB('FF8080');

        foreach (array('A','B','C','D','E','F','G') as $val) {
            $cellStyle = $activeSheet ->getStyle($val.'12');
            $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
            $cellStyle ->getFont()->setBold(true);
        }
        
        // row 13
        $activeSheet ->mergeCells('A13:G13')
                ->getStyle('A13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                ->getStartColor()->setRGB('CC99FF');
        $activeSheet ->setCellValue('A13', 'ВОДИТЕЛИ');
        $activeSheet ->getStyle('A13') ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
        $activeSheet ->getStyle('A13') ->getFont()->setBold(true);
        $activeSheet ->getStyle('A13:G13') ->getBorders() ->applyFromArray( self::$bordersAll );

        $r = 1;
        foreach (array('14','17','20','23','26','29','32','35',) as $rowNo) {
            
            // row 14
            $activeSheet ->mergeCells('A'.$rowNo.':G'.$rowNo)
                    ->getStyle('A'.$rowNo)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID )
                    ->getStartColor()->setRGB('DDDDDD');
            $activeSheet ->setCellValue('A'.$rowNo, $r);
            $activeSheet ->getStyle('A'.$rowNo) ->getAlignment() ->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
            $activeSheet ->getStyle('A'.$rowNo) ->getFont()->setBold(true);
            $activeSheet ->getStyle('A'.$rowNo.':G'.$rowNo) ->getBorders() ->applyFromArray( self::$bordersAll );

            // row 15
            $activeSheet ->setCellValue('A'.($rowNo+1), 'фамилия');
            $activeSheet ->setCellValue('B'.($rowNo+1), 'имя');
            $activeSheet ->setCellValue('C'.($rowNo+1), 'отчество');
            $activeSheet ->setCellValue('D'.($rowNo+1), 'дата рождения');
            $activeSheet ->setCellValue('E'.($rowNo+1), 'серия в/у');
            $activeSheet ->setCellValue('F'.($rowNo+1), 'номер в/у');
            $activeSheet ->setCellValue('G'.($rowNo+1), 'дата начала стажа');

            foreach (array('A','B','C','D','E','F','G') as $val) {
                $cellStyle = $activeSheet ->getStyle($val.($rowNo+1));
                $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
            }

            // row 16
            $activeSheet ->setCellValue('A'.($rowNo+2), 'Полищук');
            $activeSheet ->setCellValue('B'.($rowNo+2), 'Артем');
            $activeSheet ->setCellValue('C'.($rowNo+2), 'Викторович');
            $activeSheet ->setCellValue('D'.($rowNo+2), '07.01.1984');
            $activeSheet ->setCellValue('E'.($rowNo+2), '2565');
            $activeSheet ->setCellValue('F'.($rowNo+2), '235484');
            $activeSheet ->setCellValue('G'.($rowNo+2), '12.05.1994');

            foreach (array('A','B','C','D','E','F','G') as $val) {
                $cellStyle = $activeSheet ->getStyle($val.($rowNo+2));
                $cellStyle ->getBorders() ->applyFromArray( self::$bordersAll );
                $cellStyle ->getFont()->setBold(true);
            }
            
            $r++;
            
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
        
        
        $phpExcelObject->getActiveSheet()->setTitle('Simple');
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
