<?php

use Symfony\Component\DomCrawler\Crawler;

include 'Request.php';

class CrawlerMG
{

  public function execute()
  {

    $request = new Request();
    $htmlRequest = $request->getRequest('https://www.mg.gov.br/servico/agendar-visitas-guiadas-na-biblioteca-publica-estadual-de-minas-gerais');

    $crawler = new Crawler($htmlRequest);

    $main = $crawler->filter('div#conteudo-servico')->each(function ($contentContainer) {
      /** @var \Symfony\Component\DomCrawler\Crawler $contentContainer */
      $update = $contentContainer->filter('div.field-name-changed-date .field-items')->text();
      $what = $contentContainer->filter('div.field-name-field-descricao .field-items')->text();
      $who = $contentContainer->filter('div.field-name-field-quem-pode-utilizar-servico .field-items')->text();
      $responsible = $contentContainer->filter('div.field-name-field-filiacao .field-items')->text();

      $stage = $contentContainer->filter('div.field-name-field-descricao-etapa .field-items p ')->each(function ($contentContainerStage, $i) {
        /** @var \Symfony\Component\DomCrawler\Crawler $contentContainerStage */
        $stageCount =  $i + 1;
        return ['Etapa ' . $stageCount => $contentContainerStage->text()];
      });

      $documentation = $contentContainer->filter('div.field-name-field-documentacao-necessaria .field-items')->text();
      $value = $contentContainer->filter('div.field-name-field-custos .field-items')->text();

      $presential = $contentContainer->filter('div.field-name-field-canal-presencial .field-items')->text();
      $cellphone = $contentContainer->filter('div.field-name-field-canal-telefone .field-items')->text();
      $email = $contentContainer->filter('div.field-name-field-cana-email .field-items')->text();

      $time = $contentContainer->filter('div.field-name-field-quanto-tempo-leva .field-items')->text();
      $legislation = $contentContainer->filter('div.field-name-field-legislacao .field-items')->text();
      $others = $contentContainer->filter('div.field-name-field-outras-informacoes .field-items')->text();

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
        "Outras informações" => $others,
      ];
    });

    $service = $crawler->filter('div#unidades-prestadoras table tbody tr')->each(function ($contentContainerService, $i) {
      return [
        "Município" => $contentContainerService->filter('.views-field-field-estado-municipio')->text(),
        "Unidade" => $contentContainerService->filter('.views-field-title')->text(),
      ];
    });

    return [
      'Título' => $crawler->filter('h1.page-header')->text(),
      'Principal' => $main,
      "Unidades onde o serviço é prestado" => $service

    ];
  }
}
