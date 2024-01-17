<?php
require 'vendor/autoload.php';

use setasign\Fpdi\Fpdi as FPDI;

class PDFParser extends FPDI {
    public function extractText($filename) {
        $text = '';
        $pageCount = $this->setSourceFile($filename);

        for ($pageNum = 1; $pageNum <= $pageCount; $pageNum++) {
            $text .= $this->getPageText($pageNum);
        }

        return $text;
    }
}

class DataAnalyzer {
    public function extractElectionInfo($text) {
        // Identificar o ano da eleição
        preg_match('/Ano da Eleição: (\d+)/i', $text, $matches);
        $anoEleicao = isset($matches[1]) ? $matches[1] : '';

        // Verificar se é uma eleição para vereador
        $isVereador = preg_match('/Tipo de Eleição: Vereador/i', $text);

        // Extrair nomes dos vereadores
        preg_match_all('/Nome do Vereador: (.+)/i', $text, $matches);
        $nomesVereadores = isset($matches[1]) ? $matches[1] : [];

        // Retornar os resultados
        return [
            'anoEleicao' => $anoEleicao,
            'isVereador' => $isVereador,
            'nomesVereadores' => $nomesVereadores,
        ];
    }
}

// Exemplo de uso
$pdfParser = new FPDI();
$dataAnalyzer = new DataAnalyzer();

$pdfFilename =  "C:\Users\agmph\Downloads\archive"; 
$pdfText = $pdfParser->extractText($pdfFilename);

$resultados = $dataAnalyzer->extractElectionInfo($pdfText);

// Exibir resultados
echo "Ano da Eleição: " . $resultados['anoEleicao'] . "<br>";
echo "É uma eleição para vereador? " . ($resultados['isVereador'] ? 'Sim' : 'Não') . "<br>";
echo "Nomes dos Vereadores: " . implode(', ', $resultados['nomesVereadores']) . "<br>";

/* Buscando explorar um pouco mais no php aprendendo um pouco mais sobre sintaxes algumas aplicações 
e até onde consigo manipular dados nos php até esse momento de aprendizado.
?>
