<?php

use Symfony\Component\DomCrawler\Crawler;

include 'Request.php';

class CrawlerMG
{

  public function execute()
  {
    $htmlRequest = Request::getRequest('https://www.mg.gov.br/servico/agendar-visitas-guiadas-na-biblioteca-publica-estadual-de-minas-gerais');
    $crawler = new Crawler($htmlRequest);

    $main = $crawler->filter('div[id="conteudo-servico"]')->each(function ($contentContainer) {
      /** @var \Symfony\Component\DomCrawler\Crawler $contentContainer */
      $update = $contentContainer->filter('div[class="field field-name-changed-date field-type-ds field-label-hidden"] .field-items')->text();
      $what = $contentContainer->filter('div[class="field field-name-field-descricao field-type-text-long field-label-above"] .field-items')->text();
      $who = $contentContainer->filter('div[class="field field-name-field-quem-pode-utilizar-servico field-type-text-long field-label-above"] .field-items')->text();
      $responsible = $contentContainer->filter('div[class="field field-name-field-filiacao field-type-entityreference field-label-above"] .field-items')->text();

      $stage = $contentContainer->filter('div[class="field field-name-field-descricao-etapa field-type-text-long field-label-hidden"] .field-items p ')->each(function ($contentContainerStage, $i) {
        /** @var \Symfony\Component\DomCrawler\Crawler $contentContainerStage */
        $stageCount =  $i + 1;
        return ['Etapa ' . $stageCount => $contentContainerStage->text()];
      });

      $documentation = $contentContainer->filter('div[class="field field-name-field-documentacao-necessaria field-type-text-long field-label-above"] .field-items')->text();
      $value = $contentContainer->filter('div[class="field field-name-field-custos field-type-text-long field-label-above"] .field-items')->text();

      $presential = $contentContainer->filter('div[class="field field-name-field-canal-presencial field-type-text-long field-label-above"] .field-items')->text();
      $cellphone = $contentContainer->filter('div[class="field field-name-field-canal-telefone field-type-text field-label-above"] .field-items')->text();
      $email = $contentContainer->filter('div[class="field field-name-field-cana-email field-type-text field-label-above"] .field-items')->text();

      $time = $contentContainer->filter('div[class="field field-name-field-quanto-tempo-leva field-type-text-long field-label-above"] .field-items')->text();
      $legislation = $contentContainer->filter('div[class="field field-name-field-legislacao field-type-text-long field-label-above"] .field-items')->text();
      $others = $contentContainer->filter('div[class="field field-name-field-outras-informacoes field-type-text-long field-label-above"] .field-items')->text();

      return [
        "Atualização" => $update,
        "O que e" => $what,
        "Quem pode utilizar este serviço" => $who,
        "Órgão responsável" => $responsible,
        "Etapas para realização deste serviço" => [
          "Agendar" => $stage,
          "Documentação" => $documentation,
          "Valor" => $value,
          "Canais de Prestação" => [
            "Presencial" => $presential,
            "Telefone" => $cellphone,
            "Email" => $email,
          ],
        ],
        "Quanto tempo leva?" => $time,
        "Legislação" => $legislation,
        "Outras informações" => $others
      ];
    });

    return [
      'title' => $crawler->filter('h1[class="page-header"]')->text(),
      'principal' => $main
    ];
  }
}
