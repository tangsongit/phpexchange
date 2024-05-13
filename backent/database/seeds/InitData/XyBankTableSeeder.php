<?php

namespace Database\Seeds\InitData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class XyBankTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('xy_bank')->delete();

        DB::table('xy_bank')->insert(array(
            0 =>
            array(
                'id' => 1,
                'bank_name' => 'BCO DO BRASIL S.A.',
                'ispb' => '0',
                'code_number' => '1',
                'nome_extenso' => 'Banco do Brasil S.A.',
                'createtime' => NULL,
                'status' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'bank_name' => 'BRB - BCO DE BRASILIA S.A.',
                'ispb' => '208',
                'code_number' => '70',
                'nome_extenso' => 'BRB - BANCO DE BRASILIA S.A.',
                'createtime' => NULL,
                'status' => 0,
            ),
            2 =>
            array(
                'id' => 3,
                'bank_name' => 'Selic',
                'ispb' => '38121',
                'code_number' => 'n/a',
                'nome_extenso' => 'Banco Central do Brasil - Selic',
                'createtime' => NULL,
                'status' => 0,
            ),
            3 =>
            array(
                'id' => 4,
                'bank_name' => 'Bacen',
                'ispb' => '38166',
                'code_number' => 'n/a',
                'nome_extenso' => 'Banco Central do Brasil',
                'createtime' => NULL,
                'status' => 0,
            ),
            4 =>
            array(
                'id' => 5,
                'bank_name' => 'AGK CC S.A.',
                'ispb' => '250699',
                'code_number' => '272',
                'nome_extenso' => 'AGK CORRETORA DE CAMBIO S.A.',
                'createtime' => NULL,
                'status' => 0,
            ),
            5 =>
            array(
                'id' => 6,
                'bank_name' => 'CONF NAC COOP CENTRAIS UNICRED',
                'ispb' => '315557',
                'code_number' => '136',
                'nome_extenso' => 'CONFEDERAÇÃO NACIONAL DAS COOPERATI UNICRED DO BRASI',
                'createtime' => NULL,
                'status' => 0,
            ),
            6 =>
            array(
                'id' => 7,
                'bank_name' => 'ÍNDIGO INVESTIMENTOS DTVM LTDA.',
                'ispb' => '329598',
                'code_number' => '407',
                'nome_extenso' => 'ÍNDIGO INVESTIMENTOS DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'bank_name' => 'CAIXA ECONOMICA FEDERAL',
                'ispb' => '360305',
                'code_number' => '104',
                'nome_extenso' => 'CAIXA ECONOMICA FEDERAL',
                'createtime' => NULL,
                'status' => NULL,
            ),
            8 =>
            array(
                'id' => 9,
                'bank_name' => 'STN',
                'ispb' => '394460',
                'code_number' => 'n/a',
                'nome_extenso' => 'Secretaria do Tesouro Nacional - STN',
                'createtime' => NULL,
                'status' => NULL,
            ),
            9 =>
            array(
                'id' => 10,
                'bank_name' => 'BANCO INTER',
                'ispb' => '416968',
                'code_number' => '77',
                'nome_extenso' => 'Banco Inter S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            10 =>
            array(
                'id' => 11,
                'bank_name' => 'COLUNA S.A. DTVM',
                'ispb' => '460065',
                'code_number' => '423',
                'nome_extenso' => 'COLUNA S/A DISTRIBUIDORA DE TITULOS E VALORES MOBILIÁRIOS',
                'createtime' => NULL,
                'status' => NULL,
            ),
            11 =>
            array(
                'id' => 12,
                'bank_name' => 'BCO RIBEIRAO PRETO S.A.',
                'ispb' => '517645',
                'code_number' => '741',
                'nome_extenso' => 'BANCO RIBEIRAO PRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            12 =>
            array(
                'id' => 13,
                'bank_name' => 'BANCO BARI S.A.',
                'ispb' => '556603',
                'code_number' => '330',
                'nome_extenso' => 'BANCO BARI DE INVESTIMENTOS E FINANCIAMENTOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            13 =>
            array(
                'id' => 14,
                'bank_name' => 'BCO CETELEM S.A.',
                'ispb' => '558456',
                'code_number' => '739',
                'nome_extenso' => 'Banco Cetelem S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            14 =>
            array(
                'id' => 15,
                'bank_name' => 'BANCO SEMEAR',
                'ispb' => '795423',
                'code_number' => '743',
                'nome_extenso' => 'Banco Semear S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            15 =>
            array(
                'id' => 16,
                'bank_name' => 'PLANNER CV S.A.',
                'ispb' => '806535',
                'code_number' => '100',
                'nome_extenso' => 'Planner Corretora de Valores S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            16 =>
            array(
                'id' => 17,
                'bank_name' => 'BCO B3 S.A.',
                'ispb' => '997185',
                'code_number' => '96',
                'nome_extenso' => 'Banco B3 S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            17 =>
            array(
                'id' => 18,
                'bank_name' => 'BCO RABOBANK INTL BRASIL S.A.',
                'ispb' => '1023570',
                'code_number' => '747',
                'nome_extenso' => 'Banco Rabobank International Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            18 =>
            array(
                'id' => 19,
                'bank_name' => 'CIELO S.A.',
                'ispb' => '1027058',
                'code_number' => '362',
                'nome_extenso' => 'CIELO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            19 =>
            array(
                'id' => 20,
                'bank_name' => 'CCR DE ABELARDO LUZ',
                'ispb' => '1073966',
                'code_number' => '322',
                'nome_extenso' => 'Cooperativa de Crédito Rural de Abelardo Luz - Sulcredi/Crediluz',
                'createtime' => NULL,
                'status' => NULL,
            ),
            20 =>
            array(
                'id' => 21,
                'bank_name' => 'BCO COOPERATIVO SICREDI S.A.',
                'ispb' => '1181521',
                'code_number' => '748',
                'nome_extenso' => 'BANCO COOPERATIVO SICREDI S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            21 =>
            array(
                'id' => 22,
                'bank_name' => 'CREHNOR LARANJEIRAS',
                'ispb' => '1330387',
                'code_number' => '350',
                'nome_extenso' => 'COOPERATIVA DE CRÉDITO RURAL DE PEQUENOS AGRICULTORES E DA REFORMA AGRÁRIA DO CE',
                'createtime' => NULL,
                'status' => NULL,
            ),
            22 =>
            array(
                'id' => 23,
                'bank_name' => 'BCO BNP PARIBAS BRASIL S A',
                'ispb' => '1522368',
                'code_number' => '752',
                'nome_extenso' => 'Banco BNP Paribas Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            23 =>
            array(
                'id' => 24,
                'bank_name' => 'CCCM UNICRED CENTRAL RS',
                'ispb' => '1634601',
                'code_number' => '91',
                'nome_extenso' => 'CENTRAL DE COOPERATIVAS DE ECONOMIA E CRÉDITO MÚTUO DO ESTADO DO RIO GRANDE DO S',
                'createtime' => NULL,
                'status' => NULL,
            ),
            24 =>
            array(
                'id' => 25,
                'bank_name' => 'CECM COOPERFORTE',
                'ispb' => '1658426',
                'code_number' => '379',
                'nome_extenso' => 'COOPERFORTE - COOPERATIVA DE ECONOMIA E CRÉDITO MÚTUO DE FUNCIONÁRIOS DE INSTITU',
                'createtime' => NULL,
                'status' => NULL,
            ),
            25 =>
            array(
                'id' => 26,
                'bank_name' => 'KIRTON BANK',
                'ispb' => '1701201',
                'code_number' => '399',
                'nome_extenso' => 'Kirton Bank S.A. - Banco Múltiplo',
                'createtime' => NULL,
                'status' => NULL,
            ),
            26 =>
            array(
                'id' => 27,
                'bank_name' => 'PORTOCRED S.A. - CFI',
                'ispb' => '1800019',
                'code_number' => '108',
                'nome_extenso' => 'PORTOCRED S.A. - CREDITO, FINANCIAMENTO E INVESTIMENTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            27 =>
            array(
                'id' => 28,
                'bank_name' => 'BBC LEASING',
                'ispb' => '1852137',
                'code_number' => '378',
                'nome_extenso' => 'BBC LEASING S.A. - ARRENDAMENTO MERCANTIL',
                'createtime' => NULL,
                'status' => NULL,
            ),
            28 =>
            array(
                'id' => 29,
                'bank_name' => 'BCO BV S.A.',
                'ispb' => '1858774',
                'code_number' => '413',
                'nome_extenso' => 'BANCO BV S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            29 =>
            array(
                'id' => 30,
                'bank_name' => 'BANCO SICOOB S.A.',
                'ispb' => '2038232',
                'code_number' => '756',
                'nome_extenso' => 'BANCO COOPERATIVO SICOOB S.A. - BANCO SICOOB',
                'createtime' => NULL,
                'status' => NULL,
            ),
            30 =>
            array(
                'id' => 31,
                'bank_name' => 'TRINUS CAPITAL DTVM',
                'ispb' => '2276653',
                'code_number' => '360',
                'nome_extenso' => 'TRINUS CAPITAL DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            31 =>
            array(
                'id' => 32,
                'bank_name' => 'BCO KEB HANA DO BRASIL S.A.',
                'ispb' => '2318507',
                'code_number' => '757',
                'nome_extenso' => 'BANCO KEB HANA DO BRASIL S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            32 =>
            array(
                'id' => 33,
                'bank_name' => 'XP INVESTIMENTOS CCTVM S/A',
                'ispb' => '2332886',
                'code_number' => '102',
                'nome_extenso' => 'XP INVESTIMENTOS CORRETORA DE CÂMBIO,TÍTULOS E VALORES MOBILIÁRIOS S/A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            33 =>
            array(
                'id' => 34,
                'bank_name' => 'UNIPRIME NORTE DO PARANÁ - CC',
                'ispb' => '2398976',
                'code_number' => '84',
                'nome_extenso' => 'UNIPRIME NORTE DO PARANÁ - COOPERATIVA DE CRÉDITO LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            34 =>
            array(
                'id' => 35,
                'bank_name' => 'CM CAPITAL MARKETS CCTVM LTDA',
                'ispb' => '2685483',
                'code_number' => '180',
                'nome_extenso' => 'CM CAPITAL MARKETS CORRETORA DE CÂMBIO, TÍTULOS E VALORES MOBILIÁRIOSLTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            35 =>
            array(
                'id' => 36,
                'bank_name' => 'BCO MORGAN STANLEY S.A.',
                'ispb' => '2801938',
                'code_number' => '66',
                'nome_extenso' => 'BANCO MORGAN STANLEY S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            36 =>
            array(
                'id' => 37,
                'bank_name' => 'UBS BRASIL CCTVM S.A.',
                'ispb' => '2819125',
                'code_number' => '15',
                'nome_extenso' => 'UBS Brasil Corretora de Câmbio, Títulos e Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            37 =>
            array(
                'id' => 38,
                'bank_name' => 'TREVISO CC S.A.',
                'ispb' => '2992317',
                'code_number' => '143',
                'nome_extenso' => 'Treviso Corretora de Câmbio S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            38 =>
            array(
                'id' => 39,
                'bank_name' => 'CIP Siloc',
                'ispb' => '2992335',
                'code_number' => 'n/a',
                'nome_extenso' => 'Câmara Interbancária de Pagamentos - CIP - LDL',
                'createtime' => NULL,
                'status' => NULL,
            ),
            39 =>
            array(
                'id' => 40,
                'bank_name' => 'HIPERCARD BM S.A.',
                'ispb' => '3012230',
                'code_number' => '62',
                'nome_extenso' => 'Hipercard Banco Múltiplo S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            40 =>
            array(
                'id' => 41,
                'bank_name' => 'BCO. J.SAFRA S.A.',
                'ispb' => '3017677',
                'code_number' => '74',
                'nome_extenso' => 'Banco J. Safra S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            41 =>
            array(
                'id' => 42,
                'bank_name' => 'UNIPRIME CENTRAL CCC LTDA.',
                'ispb' => '3046391',
                'code_number' => '99',
                'nome_extenso' => 'UNIPRIME CENTRAL - CENTRAL INTERESTADUAL DE COOPERATIVAS DE CREDITO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            42 =>
            array(
                'id' => 43,
                'bank_name' => 'BCO TOYOTA DO BRASIL S.A.',
                'ispb' => '3215790',
                'code_number' => '387',
                'nome_extenso' => 'Banco Toyota do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            43 =>
            array(
                'id' => 44,
                'bank_name' => 'PARATI - CFI S.A.',
                'ispb' => '3311443',
                'code_number' => '326',
                'nome_extenso' => 'PARATI - CREDITO, FINANCIAMENTO E INVESTIMENTO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            44 =>
            array(
                'id' => 45,
                'bank_name' => 'BCO ALFA S.A.',
                'ispb' => '3323840',
                'code_number' => '25',
                'nome_extenso' => 'Banco Alfa S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            45 =>
            array(
                'id' => 46,
                'bank_name' => 'PI DTVM S.A.',
                'ispb' => '3502968',
                'code_number' => '315',
                'nome_extenso' => 'PI Distribuidora de Títulos e Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            46 =>
            array(
                'id' => 47,
                'bank_name' => 'BCO ABN AMRO S.A.',
                'ispb' => '3532415',
                'code_number' => '75',
                'nome_extenso' => 'Banco ABN Amro S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            47 =>
            array(
                'id' => 48,
                'bank_name' => 'BCO CARGILL S.A.',
                'ispb' => '3609817',
                'code_number' => '40',
                'nome_extenso' => 'Banco Cargill S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            48 =>
            array(
                'id' => 49,
                'bank_name' => 'TERRA INVESTIMENTOS DTVM',
                'ispb' => '3751794',
                'code_number' => '307',
                'nome_extenso' => 'Terra Investimentos Distribuidora de Títulos e Valores Mobiliários Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            49 =>
            array(
                'id' => 50,
                'bank_name' => 'SERVICOOP',
                'ispb' => '3973814',
                'code_number' => '190',
                'nome_extenso' => 'SERVICOOP - COOPERATIVA DE CRÉDITO DOS SERVIDORES PÚBLICOS ESTADUAIS DO RIO GRAN',
                'createtime' => NULL,
                'status' => NULL,
            ),
            50 =>
            array(
                'id' => 51,
                'bank_name' => 'VISION S.A. CC',
                'ispb' => '4062902',
                'code_number' => '296',
                'nome_extenso' => 'VISION S.A. CORRETORA DE CAMBIO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            51 =>
            array(
                'id' => 52,
                'bank_name' => 'BANCO BRADESCARD',
                'ispb' => '4184779',
                'code_number' => '63',
                'nome_extenso' => 'Banco Bradescard S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            52 =>
            array(
                'id' => 53,
                'bank_name' => 'NOVA FUTURA CTVM LTDA.',
                'ispb' => '4257795',
                'code_number' => '191',
                'nome_extenso' => 'Nova Futura Corretora de Títulos e Valores Mobiliários Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            53 =>
            array(
                'id' => 54,
                'bank_name' => 'FIDUCIA SCMEPP LTDA',
                'ispb' => '4307598',
                'code_number' => '382',
                'nome_extenso' => 'FIDÚCIA SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE',
                'createtime' => NULL,
                'status' => NULL,
            ),
            54 =>
            array(
                'id' => 55,
                'bank_name' => 'GOLDMAN SACHS DO BRASIL BM S.A',
                'ispb' => '4332281',
                'code_number' => '64',
                'nome_extenso' => 'PEQUENO PORTE L',
                'createtime' => NULL,
                'status' => NULL,
            ),
            55 =>
            array(
                'id' => 56,
                'bank_name' => 'CAMARA INTERBANCARIA DE PAGAMENTOS - CIP',
                'ispb' => '4391007',
                'code_number' => 'n/a',
                'nome_extenso' => 'GOLDMAN SACHS DO BRASIL BANCO MULTIPLO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            56 =>
            array(
                'id' => 57,
                'bank_name' => 'CREDISIS CENTRAL DE COOPERATIVAS DE CRÉDITO LTDA.',
                'ispb' => '4632856',
                'code_number' => '97',
                'nome_extenso' => 'Câmara Interbancária de Pagamentos',
                'createtime' => NULL,
                'status' => NULL,
            ),
            57 =>
            array(
                'id' => 58,
                'bank_name' => 'CCM DESP TRÂNS SC E RS',
                'ispb' => '4715685',
                'code_number' => '16',
                'nome_extenso' => 'Credisis - Central de Cooperativas de Crédito Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            58 =>
            array(
                'id' => 59,
                'bank_name' => 'BCO SOROCRED S.A. - BM',
                'ispb' => '4814563',
                'code_number' => '299',
                'nome_extenso' => 'COOPERATIVA DE CRÉDITO MÚTUO DOS DESPACHANTES DE TRÂNSITO DE SANTA CATARINA E RI',
                'createtime' => NULL,
                'status' => NULL,
            ),
            59 =>
            array(
                'id' => 60,
                'bank_name' => 'BANCO INBURSA',
                'ispb' => '4866275',
                'code_number' => '12',
                'nome_extenso' => 'BANCO SOROCRED S.A. - BANCO MÚLTIPLO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            60 =>
            array(
                'id' => 61,
                'bank_name' => 'BCO DA AMAZONIA S.A.',
                'ispb' => '4902979',
                'code_number' => '3',
                'nome_extenso' => 'Banco Inbursa S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            61 =>
            array(
                'id' => 62,
                'bank_name' => 'CONFIDENCE CC S.A.',
                'ispb' => '4913129',
                'code_number' => '60',
                'nome_extenso' => 'BANCO DA AMAZONIA S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            62 =>
            array(
                'id' => 63,
                'bank_name' => 'BCO DO EST. DO PA S.A.',
                'ispb' => '4913711',
                'code_number' => '37',
                'nome_extenso' => 'Confidence Corretora de Câmbio S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            63 =>
            array(
                'id' => 64,
                'bank_name' => 'VIA CERTA FINANCIADORA S.A. - CFI',
                'ispb' => '5192316',
                'code_number' => '411',
                'nome_extenso' => 'Banco do Estado do Pará S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            64 =>
            array(
                'id' => 65,
                'bank_name' => 'ZEMA CFI S/A',
                'ispb' => '5351887',
                'code_number' => '359',
                'nome_extenso' => 'Via Certa Financiadora S.A. - Crédito, Financiamento e Investimentos',
                'createtime' => NULL,
                'status' => NULL,
            ),
            65 =>
            array(
                'id' => 66,
                'bank_name' => 'CASA CREDITO S.A. SCM',
                'ispb' => '5442029',
                'code_number' => '159',
                'nome_extenso' => 'ZEMA CRÉDITO, FINANCIAMENTO E INVESTIMENTO S/A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            66 =>
            array(
                'id' => 67,
                'bank_name' => 'COOP CENTRAL AILOS',
                'ispb' => '5463212',
                'code_number' => '85',
                'nome_extenso' => 'Casa do Crédito S.A. Sociedade de Crédito ao Microempreendedor',
                'createtime' => NULL,
                'status' => NULL,
            ),
            67 =>
            array(
                'id' => 68,
                'bank_name' => 'CC POUP SER FIN CO',
                'ispb' => '5491616',
                'code_number' => '400',
                'nome_extenso' => 'Cooperativa Central de Crédito - Ailos',
                'createtime' => NULL,
                'status' => NULL,
            ),
            68 =>
            array(
                'id' => 69,
                'bank_name' => 'PLANNER SCM S.A.',
                'ispb' => '5684234',
                'code_number' => '410',
                'nome_extenso' => 'COOPERATIVA DE CRÉDITO, POUPANÇA E SERVIÇOS FINANCEIROS DO CENTRO OESTE',
                'createtime' => NULL,
                'status' => NULL,
            ),
            69 =>
            array(
                'id' => 70,
                'bank_name' => 'CENTRAL COOPERATIVA DE CRÉDITO NO ESTADO DO ESPÍRITO SANTO',
                'ispb' => '5790149',
                'code_number' => '114',
                'nome_extenso' => 'PLANNER SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            70 =>
            array(
                'id' => 71,
                'bank_name' => 'CECM FABRIC CALÇADOS SAPIRANGA',
                'ispb' => '5841967',
                'code_number' => '328',
                'nome_extenso' => 'Central Cooperativa de Crédito no Estado do Espírito Santo - CECOOP',
                'createtime' => NULL,
                'status' => NULL,
            ),
            71 =>
            array(
                'id' => 72,
                'bank_name' => 'BCO BBI S.A.',
                'ispb' => '6271464',
                'code_number' => '36',
                'nome_extenso' => 'COOPERATIVA DE ECONOMIA E CRÉDITO MÚTUO DOS FABRICANTES DE CALÇADOS DE SAPIRANGA Banco Bradesco BBI S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            72 =>
            array(
                'id' => 73,
                'bank_name' => 'BCO BRADESCO FINANC. S.A.',
                'ispb' => '7207996',
                'code_number' => '394',
                'nome_extenso' => 'Banco Bradesco Financiamentos S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            73 =>
            array(
                'id' => 74,
                'bank_name' => 'BCO DO NORDESTE DO BRASIL S.A.',
                'ispb' => '7237373',
                'code_number' => '4',
                'nome_extenso' => 'Banco do Nordeste do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            74 =>
            array(
                'id' => 75,
                'bank_name' => 'BCO CCB BRASIL S.A.',
                'ispb' => '7450604',
                'code_number' => '320',
                'nome_extenso' => 'China Construction Bank (Brasil) Banco Múltiplo S/A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            75 =>
            array(
                'id' => 76,
                'bank_name' => 'HS FINANCEIRA',
                'ispb' => '7512441',
                'code_number' => '189',
                'nome_extenso' => 'HS FINANCEIRA S/A CREDITO, FINANCIAMENTO E INVESTIMENTOS',
                'createtime' => NULL,
                'status' => NULL,
            ),
            76 =>
            array(
                'id' => 77,
                'bank_name' => 'LECCA CFI S.A.',
                'ispb' => '7652226',
                'code_number' => '105',
                'nome_extenso' => 'Lecca Crédito, Financiamento e Investimento S/A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            77 =>
            array(
                'id' => 78,
                'bank_name' => 'BCO KDB BRASIL S.A.',
                'ispb' => '7656500',
                'code_number' => '76',
                'nome_extenso' => 'Banco KDB do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            78 =>
            array(
                'id' => 79,
                'bank_name' => 'BANCO TOPÁZIO S.A.',
                'ispb' => '7679404',
                'code_number' => '82',
                'nome_extenso' => 'BANCO TOPÁZIO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            79 =>
            array(
                'id' => 80,
                'bank_name' => 'HSCM SCMEPP LTDA.',
                'ispb' => '7693858',
                'code_number' => '312',
                'nome_extenso' => 'HSCM - SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE LT COOPERATIVA DE CRÉDITO RURAL DE OURO SULCREDI/OURO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            80 =>
            array(
                'id' => 81,
                'bank_name' => 'CCR DE OURO',
                'ispb' => '7853842',
                'code_number' => '286',
                'nome_extenso' => 'PÓLOCRED SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORT',
                'createtime' => NULL,
                'status' => NULL,
            ),
            81 =>
            array(
                'id' => 82,
                'bank_name' => 'POLOCRED SCMEPP LTDA.',
                'ispb' => '7945233',
                'code_number' => '93',
                'nome_extenso' => 'COOPERATIVA DE CREDITO RURAL DE IBIAM - SULCREDI/IBIAM',
                'createtime' => NULL,
                'status' => NULL,
            ),
            82 =>
            array(
                'id' => 83,
                'bank_name' => 'CCR DE IBIAM',
                'ispb' => '8240446',
                'code_number' => '391',
                'nome_extenso' => 'Cooperativa de Crédito Rural de São Miguel do Oeste - Sulcredi/São Miguel',
                'createtime' => NULL,
                'status' => NULL,
            ),
            83 =>
            array(
                'id' => 84,
                'bank_name' => 'CCR DE SÃO MIGUEL DO OESTE',
                'ispb' => '8253539',
                'code_number' => '273',
                'nome_extenso' => 'Banco CSF S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            84 =>
            array(
                'id' => 85,
                'bank_name' => 'BCO CSF S.A.',
                'ispb' => '8357240',
                'code_number' => '368',
                'nome_extenso' => 'Pagseguro Internet S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            85 =>
            array(
                'id' => 86,
                'bank_name' => 'PAGSEGURO S.A.',
                'ispb' => '8561701',
                'code_number' => '290',
                'nome_extenso' => 'MONEYCORP BANCO DE CÂMBIO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            86 =>
            array(
                'id' => 87,
                'bank_name' => 'MONEYCORP BCO DE CÂMBIO S.A.',
                'ispb' => '8609934',
                'code_number' => '259',
                'nome_extenso' => 'F.D\'GOLD - DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            87 =>
            array(
                'id' => 88,
                'bank_name' => 'F D GOLD DTVM LTDA',
                'ispb' => '8673569',
                'code_number' => '395',
                'nome_extenso' => 'GERENCIANET S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            88 =>
            array(
                'id' => 89,
                'bank_name' => 'GERENCIANET',
                'ispb' => '9089356',
                'code_number' => '364',
                'nome_extenso' => 'ICAP do Brasil Corretora de Títulos e Valores Mobiliários Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            89 =>
            array(
                'id' => 90,
                'bank_name' => 'ICAP DO BRASIL CTVM LTDA.',
                'ispb' => '9105360',
                'code_number' => '157',
                'nome_extenso' => 'SOCRED S.A. - SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO P',
                'createtime' => NULL,
                'status' => NULL,
            ),
            90 =>
            array(
                'id' => 91,
                'bank_name' => 'SOCRED SA - SCMEPP',
                'ispb' => '9210106',
                'code_number' => '183',
                'nome_extenso' => 'STATE STREET BRASIL S.A. ? BANCO COMERCIAL',
                'createtime' => NULL,
                'status' => NULL,
            ),
            91 =>
            array(
                'id' => 92,
                'bank_name' => 'STATE STREET BR S.A. BCO COMERCIAL',
                'ispb' => '9274232',
                'code_number' => '14',
                'nome_extenso' => 'CARUANA S.A. - SOCIEDADE DE CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            92 =>
            array(
                'id' => 93,
                'bank_name' => 'CARUANA SCFI',
                'ispb' => '9313766',
                'code_number' => '130',
                'nome_extenso' => 'MIDWAY S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            93 =>
            array(
                'id' => 94,
                'bank_name' => 'MIDWAY S.A. - SCFI',
                'ispb' => '9464032',
                'code_number' => '358',
                'nome_extenso' => 'Codepe Corretora de Valores e Câmbio S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            94 =>
            array(
                'id' => 95,
                'bank_name' => 'CODEPE CVC S.A.',
                'ispb' => '9512542',
                'code_number' => '127',
                'nome_extenso' => 'Banco Original do Agronegócio S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            95 =>
            array(
                'id' => 96,
                'bank_name' => 'BCO ORIGINAL DO AGRO S/A',
                'ispb' => '9516419',
                'code_number' => '79',
                'nome_extenso' => 'Super Pagamentos e Administração de Meios Eletrônicos S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            96 =>
            array(
                'id' => 97,
                'bank_name' => 'SUPER PAGAMENTOS E ADMINISTRACAO DE MEIOS ELETRONICOS S.A.',
                'ispb' => '9554480',
                'code_number' => '340',
                'nome_extenso' => 'BancoSeguro S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            97 =>
            array(
                'id' => 98,
                'bank_name' => 'BANCOSEGURO S.A.',
                'ispb' => '10264663',
                'code_number' => '81',
                'nome_extenso' => 'CONFEDERAÇÃO NACIONAL DAS COOPERATIVAS CENTRAIS DE CRÉDITO E ECONOMIA FAMILIAR E',
                'createtime' => NULL,
                'status' => NULL,
            ),
            98 =>
            array(
                'id' => 99,
                'bank_name' => 'CRESOL CONFEDERAÇÃO',
                'ispb' => '10398952',
                'code_number' => '133',
                'nome_extenso' => 'MERCADOPAGO.COM REPRESENTACOES LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            99 =>
            array(
                'id' => 100,
                'bank_name' => 'MERCADO PAGO',
                'ispb' => '10573521',
                'code_number' => '323',
                'nome_extenso' => 'Banco Agibank S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            100 =>
            array(
                'id' => 101,
                'bank_name' => 'BCO AGIBANK S.A.',
                'ispb' => '10664513',
                'code_number' => '121',
                'nome_extenso' => 'Banco da China Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            101 =>
            array(
                'id' => 102,
                'bank_name' => 'BCO DA CHINA BRASIL S.A.',
                'ispb' => '10690848',
                'code_number' => '83',
                'nome_extenso' => 'Get Money Corretora de Câmbio S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            102 =>
            array(
                'id' => 103,
                'bank_name' => 'GET MONEY CC LTDA',
                'ispb' => '10853017',
                'code_number' => '138',
                'nome_extenso' => 'Banco Bandepe S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            103 =>
            array(
                'id' => 104,
                'bank_name' => 'BCO BANDEPE S.A.',
                'ispb' => '10866788',
                'code_number' => '24',
                'nome_extenso' => 'GLOBAL FINANÇAS SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À',
                'createtime' => NULL,
                'status' => NULL,
            ),
            104 =>
            array(
                'id' => 105,
                'bank_name' => 'GLOBAL SCM LTDA',
                'ispb' => '11165756',
                'code_number' => '384',
                'nome_extenso' => 'EMPRESA DE PEQUENO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            105 =>
            array(
                'id' => 106,
                'bank_name' => 'BIORC FINANCEIRA - CFI S.A.',
                'ispb' => '11285104',
                'code_number' => '426',
                'nome_extenso' => 'Biorc Financeira - Crédito, Financiamento e Investimento S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            106 =>
            array(
                'id' => 107,
                'bank_name' => 'BANCO RANDON S.A.',
                'ispb' => '11476673',
                'code_number' => '88',
                'nome_extenso' => 'BANCO RANDON S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            107 =>
            array(
                'id' => 108,
                'bank_name' => 'OM DTVM LTDA',
                'ispb' => '11495073',
                'code_number' => '319',
                'nome_extenso' => 'OM DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            108 =>
            array(
                'id' => 109,
                'bank_name' => 'MONEY PLUS SCMEPP LTDA',
                'ispb' => '11581339',
                'code_number' => '274',
                'nome_extenso' => 'MONEY PLUS SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E A EMPRESA DE PEQUENO PORT',
                'createtime' => NULL,
                'status' => NULL,
            ),
            109 =>
            array(
                'id' => 110,
                'bank_name' => 'TRAVELEX BANCO DE CÂMBIO S.A.',
                'ispb' => '11703662',
                'code_number' => '95',
                'nome_extenso' => 'Travelex Banco de Câmbio S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            110 =>
            array(
                'id' => 111,
                'bank_name' => 'BANCO FINAXIS',
                'ispb' => '11758741',
                'code_number' => '94',
                'nome_extenso' => 'Banco Finaxis S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            111 =>
            array(
                'id' => 112,
                'bank_name' => 'BCO SENFF S.A.',
                'ispb' => '11970623',
                'code_number' => '276',
                'nome_extenso' => 'BANCO SENFF S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            112 =>
            array(
                'id' => 113,
                'bank_name' => 'BRK S.A. CFI',
                'ispb' => '12865507',
                'code_number' => '92',
                'nome_extenso' => 'BRK S.A. Crédito, Financiamento e Investimento',
                'createtime' => NULL,
                'status' => NULL,
            ),
            113 =>
            array(
                'id' => 114,
                'bank_name' => 'BCO DO EST. DE SE S.A.',
                'ispb' => '13009717',
                'code_number' => '47',
                'nome_extenso' => 'Banco do Estado de Sergipe S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            114 =>
            array(
                'id' => 115,
                'bank_name' => 'BEXS BCO DE CAMBIO S.A.',
                'ispb' => '13059145',
                'code_number' => '144',
                'nome_extenso' => 'BEXS BANCO DE CÂMBIO S/A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            115 =>
            array(
                'id' => 116,
                'bank_name' => 'ACESSO SOLUCOES PAGAMENTO SA',
                'ispb' => '13140088',
                'code_number' => '332',
                'nome_extenso' => 'Acesso Soluções de Pagamento S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            116 =>
            array(
                'id' => 117,
                'bank_name' => 'BR PARTNERS BI',
                'ispb' => '13220493',
                'code_number' => '126',
                'nome_extenso' => 'BR Partners Banco de Investimento S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            117 =>
            array(
                'id' => 118,
                'bank_name' => 'ÓRAMA DTVM S.A.',
                'ispb' => '13293225',
                'code_number' => '325',
                'nome_extenso' => 'Órama Distribuidora de Títulos e Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            118 =>
            array(
                'id' => 119,
                'bank_name' => 'BPP IP S.A.',
                'ispb' => '13370835',
                'code_number' => '301',
                'nome_extenso' => 'BPP Instituição de Pagamento S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            119 =>
            array(
                'id' => 120,
                'bank_name' => 'BRL TRUST DTVM SA',
                'ispb' => '13486793',
                'code_number' => '173',
                'nome_extenso' => 'BRL Trust Distribuidora de Títulos e Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            120 =>
            array(
                'id' => 121,
                'bank_name' => 'FRAM CAPITAL DTVM S.A.',
                'ispb' => '13673855',
                'code_number' => '331',
                'nome_extenso' => 'Fram Capital Distribuidora de Títulos e Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            121 =>
            array(
                'id' => 122,
                'bank_name' => 'BCO WESTERN UNION',
                'ispb' => '13720915',
                'code_number' => '119',
                'nome_extenso' => 'Banco Western Union do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            122 =>
            array(
                'id' => 123,
                'bank_name' => 'HUB PAGAMENTOS',
                'ispb' => '13884775',
                'code_number' => '396',
                'nome_extenso' => 'HUB PAGAMENTOS S.A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            123 =>
            array(
                'id' => 124,
                'bank_name' => 'CAMBIONET CC LTDA',
                'ispb' => '14190547',
                'code_number' => '309',
                'nome_extenso' => 'CAMBIONET CORRETORA DE CÂMBIO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            124 =>
            array(
                'id' => 125,
                'bank_name' => 'PARANA BCO S.A.',
                'ispb' => '14388334',
                'code_number' => '254',
                'nome_extenso' => 'PARANÁ BANCO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            125 =>
            array(
                'id' => 126,
                'bank_name' => 'BARI CIA HIPOTECÁRIA',
                'ispb' => '14511781',
                'code_number' => '268',
                'nome_extenso' => 'BARI COMPANHIA HIPOTECÁRIA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            126 =>
            array(
                'id' => 127,
                'bank_name' => 'IUGU IP S.A.',
                'ispb' => '15111975',
                'code_number' => '401',
                'nome_extenso' => 'IUGU INSTITUIÇÃO DE PAGAMENTO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            127 =>
            array(
                'id' => 128,
                'bank_name' => 'BCO BOCOM BBM S.A.',
                'ispb' => '15114366',
                'code_number' => '107',
                'nome_extenso' => 'Banco Bocom BBM S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            128 =>
            array(
                'id' => 129,
                'bank_name' => 'BCO CAPITAL S.A.',
                'ispb' => '15173776',
                'code_number' => '412',
                'nome_extenso' => 'BANCO CAPITAL S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            129 =>
            array(
                'id' => 130,
                'bank_name' => 'BCO WOORI BANK DO BRASIL S.A.',
                'ispb' => '15357060',
                'code_number' => '124',
                'nome_extenso' => 'Banco Woori Bank do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            130 =>
            array(
                'id' => 131,
                'bank_name' => 'FACTA S.A. CFI',
                'ispb' => '15581638',
                'code_number' => '149',
                'nome_extenso' => 'Facta Financeira S.A. - Crédito Financiamento e Investimento',
                'createtime' => NULL,
                'status' => NULL,
            ),
            131 =>
            array(
                'id' => 132,
                'bank_name' => 'STONE PAGAMENTOS S.A.',
                'ispb' => '16501555',
                'code_number' => '197',
                'nome_extenso' => 'Stone Pagamentos S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            132 =>
            array(
                'id' => 133,
                'bank_name' => 'AMAZÔNIA CC LTDA.',
                'ispb' => '16927221',
                'code_number' => '313',
                'nome_extenso' => 'AMAZÔNIA CORRETORA DE CÂMBIO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            133 =>
            array(
                'id' => 134,
                'bank_name' => 'BROKER BRASIL CC LTDA.',
                'ispb' => '16944141',
                'code_number' => '142',
                'nome_extenso' => 'Broker Brasil Corretora de Câmbio Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            134 =>
            array(
                'id' => 135,
                'bank_name' => 'BCO MERCANTIL DO BRASIL S.A.',
                'ispb' => '17184037',
                'code_number' => '389',
                'nome_extenso' => 'Banco Mercantil do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            135 =>
            array(
                'id' => 136,
                'bank_name' => 'BCO ITAÚ BBA S.A.',
                'ispb' => '17298092',
                'code_number' => '184',
                'nome_extenso' => 'Banco Itaú BBA S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            136 =>
            array(
                'id' => 137,
                'bank_name' => 'BCO TRIANGULO S.A.',
                'ispb' => '17351180',
                'code_number' => '634',
                'nome_extenso' => 'BANCO TRIANGULO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            137 =>
            array(
                'id' => 138,
                'bank_name' => 'SENSO CCVM S.A.',
                'ispb' => '17352220',
                'code_number' => '545',
                'nome_extenso' => 'SENSO CORRETORA DE CAMBIO E VALORES MOBILIARIOS S.A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            138 =>
            array(
                'id' => 139,
                'bank_name' => 'ICBC DO BRASIL BM S.A.',
                'ispb' => '17453575',
                'code_number' => '132',
                'nome_extenso' => 'ICBC do Brasil Banco Múltiplo S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            139 =>
            array(
                'id' => 140,
                'bank_name' => 'VIPS CC LTDA.',
                'ispb' => '17772370',
                'code_number' => '298',
                'nome_extenso' => 'Vip\'s Corretora de Câmbio Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            140 =>
            array(
                'id' => 141,
                'bank_name' => 'BMS SCD S.A.',
                'ispb' => '17826860',
                'code_number' => '377',
                'nome_extenso' => 'BMS SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            141 =>
            array(
                'id' => 142,
                'bank_name' => 'CREFAZ SCMEPP LTDA',
                'ispb' => '18188384',
                'code_number' => '321',
                'nome_extenso' => 'CREFAZ SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E A EMPRESA DE PEQUENO PORTE LT',
                'createtime' => NULL,
                'status' => NULL,
            ),
            142 =>
            array(
                'id' => 143,
                'bank_name' => 'NU PAGAMENTOS S.A.',
                'ispb' => '18236120',
                'code_number' => '260',
                'nome_extenso' => 'Nu Pagamentos S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            143 =>
            array(
                'id' => 144,
                'bank_name' => 'UBS BRASIL BI S.A.',
                'ispb' => '18520834',
                'code_number' => '129',
                'nome_extenso' => 'UBS Brasil Banco de Investimento S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            144 =>
            array(
                'id' => 145,
                'bank_name' => 'MS BANK S.A. BCO DE CÂMBIO',
                'ispb' => '19307785',
                'code_number' => '128',
                'nome_extenso' => 'MS Bank S.A. Banco de Câmbio',
                'createtime' => NULL,
                'status' => NULL,
            ),
            145 =>
            array(
                'id' => 146,
                'bank_name' => 'LAMARA SCD S.A.',
                'ispb' => '19324634',
                'code_number' => '416',
                'nome_extenso' => 'LAMARA SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            146 =>
            array(
                'id' => 147,
                'bank_name' => 'PARMETAL DTVM LTDA',
                'ispb' => '20155248',
                'code_number' => '194',
                'nome_extenso' => 'PARMETAL DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            147 =>
            array(
                'id' => 148,
                'bank_name' => 'JUNO',
                'ispb' => '21018182',
                'code_number' => '383',
                'nome_extenso' => 'BOLETOBANCÁRIO.COM TECNOLOGIA DE PAGAMENTOS LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            148 =>
            array(
                'id' => 149,
                'bank_name' => 'CARTOS SCD S.A.',
                'ispb' => '21332862',
                'code_number' => '324',
                'nome_extenso' => 'CARTOS SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            149 =>
            array(
                'id' => 150,
                'bank_name' => 'VORTX DTVM LTDA.',
                'ispb' => '22610500',
                'code_number' => '310',
                'nome_extenso' => 'VORTX DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            150 =>
            array(
                'id' => 151,
                'bank_name' => 'PICPAY',
                'ispb' => '22896431',
                'code_number' => '380',
                'nome_extenso' => 'PICPAY SERVICOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            151 =>
            array(
                'id' => 152,
                'bank_name' => 'COMMERZBANK BRASIL S.A. - BCO MÚLTIPLO',
                'ispb' => '23522214',
                'code_number' => '163',
                'nome_extenso' => 'Commerzbank Brasil S.A. - Banco Múltiplo',
                'createtime' => NULL,
                'status' => NULL,
            ),
            152 =>
            array(
                'id' => 153,
                'bank_name' => 'WILL FINANCEIRA S.A.CFI',
                'ispb' => '23862762',
                'code_number' => '280',
                'nome_extenso' => 'WILL FINANCEIRA S.A. CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            153 =>
            array(
                'id' => 154,
                'bank_name' => 'GUITTA CC LTDA',
                'ispb' => '24074692',
                'code_number' => '146',
                'nome_extenso' => 'GUITTA CORRETORA DE CAMBIO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            154 =>
            array(
                'id' => 155,
                'bank_name' => 'FFA SCMEPP LTDA.',
                'ispb' => '24537861',
                'code_number' => '343',
                'nome_extenso' => 'FFA SOCIEDADE DE CRÉDITO AO MICROEMPREENDEDOR E À EMPRESA DE PEQUENO PORTE LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            155 =>
            array(
                'id' => 156,
                'bank_name' => 'CCR DE PRIMAVERA DO LESTE',
                'ispb' => '26563270',
                'code_number' => '279',
                'nome_extenso' => 'COOPERATIVA DE CREDITO RURAL DE PRIMAVERA DO LESTE',
                'createtime' => NULL,
                'status' => NULL,
            ),
            156 =>
            array(
                'id' => 157,
                'bank_name' => 'BANCO DIGIO',
                'ispb' => '27098060',
                'code_number' => '335',
                'nome_extenso' => 'Banco Digio S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            157 =>
            array(
                'id' => 158,
                'bank_name' => 'AL5 S.A. CFI',
                'ispb' => '27214112',
                'code_number' => '349',
                'nome_extenso' => 'AL5 S.A. CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            158 =>
            array(
                'id' => 159,
                'bank_name' => 'CRED-UFES',
                'ispb' => '27302181',
                'code_number' => '427',
                'nome_extenso' => 'COOPERATIVA DE CREDITO DOS SERVIDORES DA UNIVERSIDADE FEDERAL DO ESPIRITO SANTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            159 =>
            array(
                'id' => 160,
                'bank_name' => 'REALIZE CFI S.A.',
                'ispb' => '27351731',
                'code_number' => '374',
                'nome_extenso' => 'REALIZE CRÉDITO, FINANCIAMENTO E INVESTIMENTO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            160 =>
            array(
                'id' => 161,
                'bank_name' => 'GENIAL INVESTIMENTOS CVM S.A.',
                'ispb' => '27652684',
                'code_number' => '278',
                'nome_extenso' => 'Genial Investimentos Corretora de Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            161 =>
            array(
                'id' => 162,
                'bank_name' => 'IB CCTVM S.A.',
                'ispb' => '27842177',
                'code_number' => '271',
                'nome_extenso' => 'IB Corretora de Câmbio, Títulos e Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            162 =>
            array(
                'id' => 163,
                'bank_name' => 'BCO BANESTES S.A.',
                'ispb' => '28127603',
                'code_number' => '21',
                'nome_extenso' => 'BANESTES S.A. BANCO DO ESTADO DO ESPIRITO SANTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            163 =>
            array(
                'id' => 164,
                'bank_name' => 'BCO ABC BRASIL S.A.',
                'ispb' => '28195667',
                'code_number' => '246',
                'nome_extenso' => 'Banco ABC Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            164 =>
            array(
                'id' => 165,
                'bank_name' => 'BS2 DTVM S.A.',
                'ispb' => '28650236',
                'code_number' => '292',
                'nome_extenso' => 'BS2 Distribuidora de Títulos e Valores Mobiliários S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            165 =>
            array(
                'id' => 166,
                'bank_name' => 'Balcão B3',
                'ispb' => '28719664',
                'code_number' => 'n/a',
                'nome_extenso' => 'Sistema do Balcão B3',
                'createtime' => NULL,
                'status' => NULL,
            ),
            166 =>
            array(
                'id' => 167,
                'bank_name' => 'CIP C3',
                'ispb' => '29011780',
                'code_number' => 'n/a',
                'nome_extenso' => 'Câmara Interbancária de Pagamentos - CIP C3',
                'createtime' => NULL,
                'status' => NULL,
            ),
            167 =>
            array(
                'id' => 168,
                'bank_name' => 'SCOTIABANK BRASIL',
                'ispb' => '29030467',
                'code_number' => '751',
                'nome_extenso' => 'Scotiabank Brasil S.A. Banco Múltiplo',
                'createtime' => NULL,
                'status' => NULL,
            ),
            168 =>
            array(
                'id' => 169,
                'bank_name' => 'TORO CTVM LTDA',
                'ispb' => '29162769',
                'code_number' => '352',
                'nome_extenso' => 'TORO CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            169 =>
            array(
                'id' => 170,
                'bank_name' => 'BANCO BTG PACTUAL S.A.',
                'ispb' => '30306294',
                'code_number' => '208',
                'nome_extenso' => 'Banco BTG Pactual S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            170 =>
            array(
                'id' => 171,
                'bank_name' => 'NU FINANCEIRA S.A. CFI',
                'ispb' => '30680829',
                'code_number' => '386',
                'nome_extenso' => 'NU FINANCEIRA S.A. - Sociedade de Crédito, Financiamento e Investimento',
                'createtime' => NULL,
                'status' => NULL,
            ),
            171 =>
            array(
                'id' => 172,
                'bank_name' => 'BCO MODAL S.A.',
                'ispb' => '30723886',
                'code_number' => '746',
                'nome_extenso' => 'Banco Modal S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            172 =>
            array(
                'id' => 173,
                'bank_name' => 'BCO CLASSICO S.A.',
                'ispb' => '31597552',
                'code_number' => '241',
                'nome_extenso' => 'BANCO CLASSICO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            173 =>
            array(
                'id' => 174,
                'bank_name' => 'IDEAL CTVM S.A.',
                'ispb' => '31749596',
                'code_number' => '398',
                'nome_extenso' => 'IDEAL CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            174 =>
            array(
                'id' => 175,
                'bank_name' => 'BCO C6 S.A.',
                'ispb' => '31872495',
                'code_number' => '336',
                'nome_extenso' => 'Banco C6 S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            175 =>
            array(
                'id' => 176,
                'bank_name' => 'BCO GUANABARA S.A.',
                'ispb' => '31880826',
                'code_number' => '612',
                'nome_extenso' => 'Banco Guanabara S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            176 =>
            array(
                'id' => 177,
                'bank_name' => 'BCO INDUSTRIAL DO BRASIL S.A.',
                'ispb' => '31895683',
                'code_number' => '604',
                'nome_extenso' => 'Banco Industrial do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            177 =>
            array(
                'id' => 178,
                'bank_name' => 'BCO CREDIT SUISSE S.A.',
                'ispb' => '32062580',
                'code_number' => '505',
                'nome_extenso' => 'Banco Credit Suisse (Brasil) S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            178 =>
            array(
                'id' => 179,
                'bank_name' => 'QI SCD S.A.',
                'ispb' => '32402502',
                'code_number' => '329',
                'nome_extenso' => 'QI Sociedade de Crédito Direto S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            179 =>
            array(
                'id' => 180,
                'bank_name' => 'FAIR CC S.A.',
                'ispb' => '32648370',
                'code_number' => '196',
                'nome_extenso' => 'FAIR CORRETORA DE CAMBIO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            180 =>
            array(
                'id' => 181,
                'bank_name' => 'CREDITAS SCD',
                'ispb' => '32997490',
                'code_number' => '342',
                'nome_extenso' => 'Creditas Sociedade de Crédito Direto S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            181 =>
            array(
                'id' => 182,
                'bank_name' => 'BCO LA NACION ARGENTINA',
                'ispb' => '33042151',
                'code_number' => '300',
                'nome_extenso' => 'Banco de la Nacion Argentina',
                'createtime' => NULL,
                'status' => NULL,
            ),
            182 =>
            array(
                'id' => 183,
                'bank_name' => 'CITIBANK N.A.',
                'ispb' => '33042953',
                'code_number' => '477',
                'nome_extenso' => 'Citibank N.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            183 =>
            array(
                'id' => 184,
                'bank_name' => 'BCO CEDULA S.A.',
                'ispb' => '33132044',
                'code_number' => '266',
                'nome_extenso' => 'BANCO CEDULA S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            184 =>
            array(
                'id' => 185,
                'bank_name' => 'BCO BRADESCO BERJ S.A.',
                'ispb' => '33147315',
                'code_number' => '122',
                'nome_extenso' => 'Banco Bradesco BERJ S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            185 =>
            array(
                'id' => 186,
                'bank_name' => 'BCO J.P. MORGAN S.A.',
                'ispb' => '33172537',
                'code_number' => '376',
                'nome_extenso' => 'BANCO J.P. MORGAN S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            186 =>
            array(
                'id' => 187,
                'bank_name' => 'BCO XP S.A.',
                'ispb' => '33264668',
                'code_number' => '348',
                'nome_extenso' => 'Banco XP S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            187 =>
            array(
                'id' => 188,
                'bank_name' => 'BCO CAIXA GERAL BRASIL S.A.',
                'ispb' => '33466988',
                'code_number' => '473',
                'nome_extenso' => 'Banco Caixa Geral - Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            188 =>
            array(
                'id' => 189,
                'bank_name' => 'BCO CITIBANK S.A.',
                'ispb' => '33479023',
                'code_number' => '745',
                'nome_extenso' => 'Banco Citibank S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            189 =>
            array(
                'id' => 190,
                'bank_name' => 'BCO RODOBENS S.A.',
                'ispb' => '33603457',
                'code_number' => '120',
                'nome_extenso' => 'BANCO RODOBENS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            190 =>
            array(
                'id' => 191,
                'bank_name' => 'BCO FATOR S.A.',
                'ispb' => '33644196',
                'code_number' => '265',
                'nome_extenso' => 'Banco Fator S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            191 =>
            array(
                'id' => 192,
                'bank_name' => 'BNDES',
                'ispb' => '33657248',
                'code_number' => '7',
                'nome_extenso' => 'BANCO NACIONAL DE DESENVOLVIMENTO ECONOMICO E SOCIAL',
                'createtime' => NULL,
                'status' => NULL,
            ),
            192 =>
            array(
                'id' => 193,
                'bank_name' => 'ATIVA S.A. INVESTIMENTOS CCTVM',
                'ispb' => '33775974',
                'code_number' => '188',
                'nome_extenso' => 'ATIVA INVESTIMENTOS S.A. CORRETORA DE TÍTULOS, CÂMBIO E VALORES',
                'createtime' => NULL,
                'status' => NULL,
            ),
            193 =>
            array(
                'id' => 194,
                'bank_name' => 'BGC LIQUIDEZ DTVM LTDA',
                'ispb' => '33862244',
                'code_number' => '134',
                'nome_extenso' => 'BGC LIQUIDEZ DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            194 =>
            array(
                'id' => 195,
                'bank_name' => 'BANCO ITAÚ CONSIGNADO S.A.',
                'ispb' => '33885724',
                'code_number' => '29',
                'nome_extenso' => 'Banco Itaú Consignado S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            195 =>
            array(
                'id' => 196,
                'bank_name' => 'BCO MÁXIMA S.A.',
                'ispb' => '33923798',
                'code_number' => '243',
                'nome_extenso' => 'Banco Máxima S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            196 =>
            array(
                'id' => 197,
                'bank_name' => 'LISTO SCD S.A.',
                'ispb' => '34088029',
                'code_number' => '397',
                'nome_extenso' => 'LISTO SOCIEDADE DE CREDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            197 =>
            array(
                'id' => 198,
                'bank_name' => 'HAITONG BI DO BRASIL S.A.',
                'ispb' => '34111187',
                'code_number' => '78',
                'nome_extenso' => 'Haitong Banco de Investimento do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            198 =>
            array(
                'id' => 199,
                'bank_name' => 'ÓTIMO SCD S.A.',
                'ispb' => '34335592',
                'code_number' => '355',
                'nome_extenso' => 'ÓTIMO SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            199 =>
            array(
                'id' => 200,
                'bank_name' => 'VITREO DTVM S.A.',
                'ispb' => '34711571',
                'code_number' => '367',
                'nome_extenso' => 'VITREO DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            200 =>
            array(
                'id' => 201,
                'bank_name' => 'PLANTAE CFI',
                'ispb' => '35551187',
                'code_number' => '445',
                'nome_extenso' => 'PLANTAE S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            201 =>
            array(
                'id' => 202,
                'bank_name' => 'UP.P SEP S.A.',
                'ispb' => '35977097',
                'code_number' => '373',
                'nome_extenso' => 'UP.P SOCIEDADE DE EMPRÉSTIMO ENTRE PESSOAS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            202 =>
            array(
                'id' => 203,
                'bank_name' => 'OLIVEIRA TRUST DTVM S.A.',
                'ispb' => '36113876',
                'code_number' => '111',
                'nome_extenso' => 'OLIVEIRA TRUST DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIARIOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            203 =>
            array(
                'id' => 204,
                'bank_name' => 'BONUSPAGO SCD S.A.',
                'ispb' => '36586946',
                'code_number' => '408',
                'nome_extenso' => 'BONUSPAGO SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            204 =>
            array(
                'id' => 205,
                'bank_name' => 'COBUCCIO SCD S.A.',
                'ispb' => '36947229',
                'code_number' => '402',
                'nome_extenso' => 'COBUCCIO SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            205 =>
            array(
                'id' => 206,
                'bank_name' => 'SUMUP SCD S.A.',
                'ispb' => '37241230',
                'code_number' => '404',
                'nome_extenso' => 'SUMUP SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            206 =>
            array(
                'id' => 207,
                'bank_name' => 'WORK SCD S.A.',
                'ispb' => '37526080',
                'code_number' => '414',
                'nome_extenso' => 'WORK SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            207 =>
            array(
                'id' => 208,
                'bank_name' => 'ACCREDITO SCD S.A.',
                'ispb' => '37715993',
                'code_number' => '406',
                'nome_extenso' => 'ACCREDITO - SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            208 =>
            array(
                'id' => 209,
                'bank_name' => 'CORA SCD S.A.',
                'ispb' => '37880206',
                'code_number' => '403',
                'nome_extenso' => 'CORA SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            209 =>
            array(
                'id' => 210,
                'bank_name' => 'NUMBRS SCD S.A.',
                'ispb' => '38129006',
                'code_number' => '419',
                'nome_extenso' => 'NUMBRS SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            210 =>
            array(
                'id' => 211,
                'bank_name' => 'CRED-SYSTEM SCD S.A.',
                'ispb' => '39664698',
                'code_number' => '428',
                'nome_extenso' => 'CRED-SYSTEM SOCIEDADE DE CRÉDITO DIRETO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            211 =>
            array(
                'id' => 212,
                'bank_name' => 'PORTOPAR DTVM LTDA',
                'ispb' => '40303299',
                'code_number' => '306',
                'nome_extenso' => 'PORTOPAR DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            212 =>
            array(
                'id' => 213,
                'bank_name' => 'BNY MELLON BCO S.A.',
                'ispb' => '42272526',
                'code_number' => '17',
                'nome_extenso' => 'BNY Mellon Banco S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            213 =>
            array(
                'id' => 214,
                'bank_name' => 'PEFISA S.A. - CFI',
                'ispb' => '43180355',
                'code_number' => '174',
                'nome_extenso' => 'PEFISA S.A. - CRÉDITO, FINANCIAMENTO E INVESTIMENTO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            214 =>
            array(
                'id' => 215,
                'bank_name' => 'BR-CAPITAL DTVM S.A.',
                'ispb' => '44077014',
                'code_number' => '433',
                'nome_extenso' => 'BR-CAPITAL DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            215 =>
            array(
                'id' => 216,
                'bank_name' => 'BCO LA PROVINCIA B AIRES BCE',
                'ispb' => '44189447',
                'code_number' => '495',
                'nome_extenso' => 'Banco de La Provincia de Buenos Aires',
                'createtime' => NULL,
                'status' => NULL,
            ),
            216 =>
            array(
                'id' => 217,
                'bank_name' => 'BANCO GENIAL',
                'ispb' => '45246410',
                'code_number' => '125',
                'nome_extenso' => 'BANCO GENIAL S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            217 =>
            array(
                'id' => 218,
                'bank_name' => 'JPMORGAN CHASE BANK',
                'ispb' => '46518205',
                'code_number' => '488',
                'nome_extenso' => 'JPMorgan Chase Bank, National Association',
                'createtime' => NULL,
                'status' => NULL,
            ),
            218 =>
            array(
                'id' => 219,
                'bank_name' => 'BCO ANDBANK S.A.',
                'ispb' => '48795256',
                'code_number' => '65',
                'nome_extenso' => 'Banco AndBank (Brasil) S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            219 =>
            array(
                'id' => 220,
                'bank_name' => 'ING BANK N.V.',
                'ispb' => '49336860',
                'code_number' => '492',
                'nome_extenso' => 'ING Bank N.V.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            220 =>
            array(
                'id' => 221,
                'bank_name' => 'LEVYCAM CCV LTDA',
                'ispb' => '50579044',
                'code_number' => '145',
                'nome_extenso' => 'LEVYCAM - CORRETORA DE CAMBIO E VALORES LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            221 =>
            array(
                'id' => 222,
                'bank_name' => 'BCV - BCO, CRÉDITO E VAREJO S.A.',
                'ispb' => '50585090',
                'code_number' => '250',
                'nome_extenso' => 'BCV - BANCO DE CRÉDITO E VAREJO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            222 =>
            array(
                'id' => 223,
                'bank_name' => 'NECTON INVESTIMENTOS S.A CVM',
                'ispb' => '52904364',
                'code_number' => '354',
                'nome_extenso' => 'NECTON INVESTIMENTOS S.A. CORRETORA DE VALORES MOBILIÁRIOS E COMMODITIES',
                'createtime' => NULL,
                'status' => NULL,
            ),
            223 =>
            array(
                'id' => 224,
                'bank_name' => 'BEXS CC S.A.',
                'ispb' => '52937216',
                'code_number' => '253',
                'nome_extenso' => 'Bexs Corretora de Câmbio S/A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            224 =>
            array(
                'id' => 225,
                'bank_name' => 'BCO HSBC S.A.',
                'ispb' => '53518684',
                'code_number' => '269',
                'nome_extenso' => 'BANCO HSBC S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            225 =>
            array(
                'id' => 226,
                'bank_name' => 'BCO ARBI S.A.',
                'ispb' => '54403563',
                'code_number' => '213',
                'nome_extenso' => 'Banco Arbi S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            226 =>
            array(
                'id' => 227,
                'bank_name' => 'Câmara B3',
                'ispb' => '54641030',
                'code_number' => 'n/a',
                'nome_extenso' => 'Câmara B3',
                'createtime' => NULL,
                'status' => NULL,
            ),
            227 =>
            array(
                'id' => 228,
                'bank_name' => 'INTESA SANPAOLO BRASIL S.A. BM',
                'ispb' => '55230916',
                'code_number' => '139',
                'nome_extenso' => 'Intesa Sanpaolo Brasil S.A. - Banco Múltiplo',
                'createtime' => NULL,
                'status' => NULL,
            ),
            228 =>
            array(
                'id' => 229,
                'bank_name' => 'BCO TRICURY S.A.',
                'ispb' => '57839805',
                'code_number' => '18',
                'nome_extenso' => 'Banco Tricury S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            229 =>
            array(
                'id' => 230,
                'bank_name' => 'BCO SAFRA S.A.',
                'ispb' => '58160789',
                'code_number' => '422',
                'nome_extenso' => 'Banco Safra S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            230 =>
            array(
                'id' => 231,
                'bank_name' => 'SMARTBANK',
                'ispb' => '58497702',
                'code_number' => '630',
                'nome_extenso' => 'Banco Smartbank S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            231 =>
            array(
                'id' => 232,
                'bank_name' => 'BCO FIBRA S.A.',
                'ispb' => '58616418',
                'code_number' => '224',
                'nome_extenso' => 'Banco Fibra S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            232 =>
            array(
                'id' => 233,
                'bank_name' => 'BCO VOLKSWAGEN S.A',
                'ispb' => '59109165',
                'code_number' => '393',
                'nome_extenso' => 'Banco Volkswagen S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            233 =>
            array(
                'id' => 234,
                'bank_name' => 'BCO LUSO BRASILEIRO S.A.',
                'ispb' => '59118133',
                'code_number' => '600',
                'nome_extenso' => 'Banco Luso Brasileiro S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            234 =>
            array(
                'id' => 235,
                'bank_name' => 'BCO GM S.A.',
                'ispb' => '59274605',
                'code_number' => '390',
                'nome_extenso' => 'BANCO GM S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            235 =>
            array(
                'id' => 236,
                'bank_name' => 'BANCO PAN',
                'ispb' => '59285411',
                'code_number' => '623',
                'nome_extenso' => 'Banco Pan S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            236 =>
            array(
                'id' => 237,
                'bank_name' => 'BCO VOTORANTIM S.A.',
                'ispb' => '59588111',
                'code_number' => '655',
                'nome_extenso' => 'Banco Votorantim S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            237 =>
            array(
                'id' => 238,
                'bank_name' => 'BCO ITAUBANK S.A.',
                'ispb' => '60394079',
                'code_number' => '479',
                'nome_extenso' => 'Banco ItauBank S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            238 =>
            array(
                'id' => 239,
                'bank_name' => 'BCO MUFG BRASIL S.A.',
                'ispb' => '60498557',
                'code_number' => '456',
                'nome_extenso' => 'Banco MUFG Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            239 =>
            array(
                'id' => 240,
                'bank_name' => 'BCO SUMITOMO MITSUI BRASIL S.A.',
                'ispb' => '60518222',
                'code_number' => '464',
                'nome_extenso' => 'Banco Sumitomo Mitsui Brasileiro S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            240 =>
            array(
                'id' => 241,
                'bank_name' => 'ITAÚ UNIBANCO S.A.',
                'ispb' => '60701190',
                'code_number' => '341',
                'nome_extenso' => 'ITAÚ UNIBANCO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            241 =>
            array(
                'id' => 242,
                'bank_name' => 'BCO BRADESCO S.A.',
                'ispb' => '60746948',
                'code_number' => '237',
                'nome_extenso' => 'Banco Bradesco S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            242 =>
            array(
                'id' => 243,
                'bank_name' => 'BCO MERCEDES-BENZ S.A.',
                'ispb' => '60814191',
                'code_number' => '381',
                'nome_extenso' => 'BANCO MERCEDES-BENZ DO BRASIL S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            243 =>
            array(
                'id' => 244,
                'bank_name' => 'OMNI BANCO S.A.',
                'ispb' => '60850229',
                'code_number' => '613',
                'nome_extenso' => 'Omni Banco S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            244 =>
            array(
                'id' => 245,
                'bank_name' => 'ITAÚ UNIBANCO HOLDING S.A.',
                'ispb' => '60872504',
                'code_number' => '652',
                'nome_extenso' => 'Itaú Unibanco Holding S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            245 =>
            array(
                'id' => 246,
                'bank_name' => 'BCO SOFISA S.A.',
                'ispb' => '60889128',
                'code_number' => '637',
                'nome_extenso' => 'BANCO SOFISA S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            246 =>
            array(
                'id' => 247,
                'bank_name' => 'Câmbio B3',
                'ispb' => '60934221',
                'code_number' => 'n/a',
                'nome_extenso' => 'Câmara de Câmbio B3',
                'createtime' => NULL,
                'status' => NULL,
            ),
            247 =>
            array(
                'id' => 248,
                'bank_name' => 'BCO INDUSVAL S.A.',
                'ispb' => '61024352',
                'code_number' => '653',
                'nome_extenso' => 'BANCO INDUSVAL S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            248 =>
            array(
                'id' => 249,
                'bank_name' => 'BCO CREFISA S.A.',
                'ispb' => '61033106',
                'code_number' => '69',
                'nome_extenso' => 'Banco Crefisa S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            249 =>
            array(
                'id' => 250,
                'bank_name' => 'BCO MIZUHO S.A.',
                'ispb' => '61088183',
                'code_number' => '370',
                'nome_extenso' => 'Banco Mizuho do Brasil S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            250 =>
            array(
                'id' => 251,
                'bank_name' => 'BANCO INVESTCRED UNIBANCO S.A.',
                'ispb' => '61182408',
                'code_number' => '249',
                'nome_extenso' => 'Banco Investcred Unibanco S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            251 =>
            array(
                'id' => 252,
                'bank_name' => 'BCO BMG S.A.',
                'ispb' => '61186680',
                'code_number' => '318',
                'nome_extenso' => 'Banco BMG S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            252 =>
            array(
                'id' => 253,
                'bank_name' => 'BCO C6 CONSIG',
                'ispb' => '61348538',
                'code_number' => '626',
                'nome_extenso' => 'BANCO C6 CONSIGNADO S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            253 =>
            array(
                'id' => 254,
                'bank_name' => 'SAGITUR CC LTDA',
                'ispb' => '61444949',
                'code_number' => '270',
                'nome_extenso' => 'Sagitur Corretora de Câmbio Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            254 =>
            array(
                'id' => 255,
                'bank_name' => 'BCO SOCIETE GENERALE BRASIL',
                'ispb' => '61533584',
                'code_number' => '366',
                'nome_extenso' => 'BANCO SOCIETE GENERALE BRASIL S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            255 =>
            array(
                'id' => 256,
                'bank_name' => 'MAGLIANO S.A. CCVM',
                'ispb' => '61723847',
                'code_number' => '113',
                'nome_extenso' => 'Magliano S.A. Corretora de Cambio e Valores Mobiliarios',
                'createtime' => NULL,
                'status' => NULL,
            ),
            256 =>
            array(
                'id' => 257,
                'bank_name' => 'TULLETT PREBON BRASIL CVC LTDA',
                'ispb' => '61747085',
                'code_number' => '131',
                'nome_extenso' => 'TULLETT PREBON BRASIL CORRETORA DE VALORES E CÂMBIO LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            257 =>
            array(
                'id' => 258,
                'bank_name' => 'C.SUISSE HEDGING-GRIFFO CV S/A',
                'ispb' => '61809182',
                'code_number' => '11',
                'nome_extenso' => 'CREDIT SUISSE HEDGING-GRIFFO CORRETORA DE VALORES S.A',
                'createtime' => NULL,
                'status' => NULL,
            ),
            258 =>
            array(
                'id' => 259,
                'bank_name' => 'BCO PAULISTA S.A.',
                'ispb' => '61820817',
                'code_number' => '611',
                'nome_extenso' => 'Banco Paulista S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            259 =>
            array(
                'id' => 260,
                'bank_name' => 'BOFA MERRILL LYNCH BM S.A.',
                'ispb' => '62073200',
                'code_number' => '755',
                'nome_extenso' => 'Bank of America Merrill Lynch Banco Múltiplo S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            260 =>
            array(
                'id' => 261,
                'bank_name' => 'CREDISAN CC',
                'ispb' => '62109566',
                'code_number' => '89',
                'nome_extenso' => 'CREDISAN COOPERATIVA DE CRÉDITO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            261 =>
            array(
                'id' => 262,
                'bank_name' => 'BCO PINE S.A.',
                'ispb' => '62144175',
                'code_number' => '643',
                'nome_extenso' => 'Banco Pine S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            262 =>
            array(
                'id' => 263,
                'bank_name' => 'EASYNVEST - TÍTULO CV SA',
                'ispb' => '62169875',
                'code_number' => '140',
                'nome_extenso' => 'Easynvest - Título Corretora de Valores SA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            263 =>
            array(
                'id' => 264,
                'bank_name' => 'BCO DAYCOVAL S.A',
                'ispb' => '62232889',
                'code_number' => '707',
                'nome_extenso' => 'Banco Daycoval S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            264 =>
            array(
                'id' => 265,
                'bank_name' => 'CAROL DTVM LTDA.',
                'ispb' => '62237649',
                'code_number' => '288',
                'nome_extenso' => 'CAROL DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            265 =>
            array(
                'id' => 266,
                'bank_name' => 'SINGULARE CTVM S.A.',
                'ispb' => '62285390',
                'code_number' => '363',
                'nome_extenso' => 'SINGULARE CORRETORA DE TÍTULOS E VALORES MOBILIÁRIOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            266 =>
            array(
                'id' => 267,
                'bank_name' => 'RENASCENCA DTVM LTDA',
                'ispb' => '62287735',
                'code_number' => '101',
                'nome_extenso' => 'RENASCENCA DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            267 =>
            array(
                'id' => 268,
                'bank_name' => 'DEUTSCHE BANK S.A.BCO ALEMAO',
                'ispb' => '62331228',
                'code_number' => '487',
                'nome_extenso' => 'DEUTSCHE BANK S.A. - BANCO ALEMAO',
                'createtime' => NULL,
                'status' => NULL,
            ),
            268 =>
            array(
                'id' => 269,
                'bank_name' => 'BANCO CIFRA',
                'ispb' => '62421979',
                'code_number' => '233',
                'nome_extenso' => 'Banco Cifra S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            269 =>
            array(
                'id' => 270,
                'bank_name' => 'GUIDE',
                'ispb' => '65913436',
                'code_number' => '177',
                'nome_extenso' => 'Guide Investimentos S.A. Corretora de Valores',
                'createtime' => NULL,
                'status' => NULL,
            ),
            270 =>
            array(
                'id' => 271,
                'bank_name' => 'PLANNER TRUSTEE DTVM LTDA',
                'ispb' => '67030395',
                'code_number' => '438',
                'nome_extenso' => 'PLANNER TRUSTEE DISTRIBUIDORA DE TÍTULOS E VALORES MOBILIÁRIOS LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            271 =>
            array(
                'id' => 272,
                'bank_name' => 'SIMPAUL',
                'ispb' => '68757681',
                'code_number' => '365',
                'nome_extenso' => 'SIMPAUL CORRETORA DE CAMBIO E VALORES MOBILIARIOS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            272 =>
            array(
                'id' => 273,
                'bank_name' => 'BCO RENDIMENTO S.A.',
                'ispb' => '68900810',
                'code_number' => '633',
                'nome_extenso' => 'Banco Rendimento S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            273 =>
            array(
                'id' => 274,
                'bank_name' => 'BCO BS2 S.A.',
                'ispb' => '71027866',
                'code_number' => '218',
                'nome_extenso' => 'Banco BS2 S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            274 =>
            array(
                'id' => 275,
                'bank_name' => 'LASTRO RDV DTVM LTDA',
                'ispb' => '71590442',
                'code_number' => '293',
                'nome_extenso' => 'Lastro RDV Distribuidora de Títulos e Valores Mobiliários Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            275 =>
            array(
                'id' => 276,
                'bank_name' => 'FRENTE CC LTDA.',
                'ispb' => '71677850',
                'code_number' => '285',
                'nome_extenso' => 'Frente Corretora de Câmbio Ltda.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            276 =>
            array(
                'id' => 277,
                'bank_name' => 'B&T CC LTDA.',
                'ispb' => '73622748',
                'code_number' => '80',
                'nome_extenso' => 'B&T CORRETORA DE CAMBIO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            277 =>
            array(
                'id' => 278,
                'bank_name' => 'NOVO BCO CONTINENTAL S.A. - BM',
                'ispb' => '74828799',
                'code_number' => '753',
                'nome_extenso' => 'Novo Banco Continental S.A. - Banco Múltiplo',
                'createtime' => NULL,
                'status' => NULL,
            ),
            278 =>
            array(
                'id' => 279,
                'bank_name' => 'BCO CRÉDIT AGRICOLE BR S.A.',
                'ispb' => '75647891',
                'code_number' => '222',
                'nome_extenso' => 'BANCO CRÉDIT AGRICOLE BRASIL S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            279 =>
            array(
                'id' => 280,
                'bank_name' => 'CCR COOPAVEL',
                'ispb' => '76461557',
                'code_number' => '281',
                'nome_extenso' => 'Cooperativa de Crédito Rural Coopavel',
                'createtime' => NULL,
                'status' => NULL,
            ),
            280 =>
            array(
                'id' => 281,
                'bank_name' => 'BANCO SISTEMA',
                'ispb' => '76543115',
                'code_number' => '754',
                'nome_extenso' => 'Banco Sistema S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            281 =>
            array(
                'id' => 282,
                'bank_name' => 'DOURADA CORRETORA',
                'ispb' => '76641497',
                'code_number' => '311',
                'nome_extenso' => 'DOURADA CORRETORA DE CÂMBIO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            282 =>
            array(
                'id' => 283,
                'bank_name' => 'CREDIALIANÇA CCR',
                'ispb' => '78157146',
                'code_number' => '98',
                'nome_extenso' => 'Credialiança Cooperativa de Crédito Rural',
                'createtime' => NULL,
                'status' => NULL,
            ),
            283 =>
            array(
                'id' => 284,
                'bank_name' => 'BCO VR S.A.',
                'ispb' => '78626983',
                'code_number' => '610',
                'nome_extenso' => 'Banco VR S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            284 =>
            array(
                'id' => 285,
                'bank_name' => 'BCO OURINVEST S.A.',
                'ispb' => '78632767',
                'code_number' => '712',
                'nome_extenso' => 'Banco Ourinvest S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            285 =>
            array(
                'id' => 286,
                'bank_name' => 'BCO RNX S.A.',
                'ispb' => '80271455',
                'code_number' => '720',
                'nome_extenso' => 'BANCO RNX S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            286 =>
            array(
                'id' => 287,
                'bank_name' => 'CREDICOAMO',
                'ispb' => '81723108',
                'code_number' => '10',
                'nome_extenso' => 'CREDICOAMO CREDITO RURAL COOPERATIVA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            287 =>
            array(
                'id' => 288,
                'bank_name' => 'RB INVESTIMENTOS DTVM LTDA.',
                'ispb' => '89960090',
                'code_number' => '283',
                'nome_extenso' => 'RB INVESTIMENTOS DISTRIBUIDORA DE TITULOS E VALORES MOBILIARIOS LIMITADA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            288 =>
            array(
                'id' => 289,
                'bank_name' => 'BCO SANTANDER (BRASIL) S.A.',
                'ispb' => '90400888',
                'code_number' => '33',
                'nome_extenso' => 'BANCO SANTANDER (BRASIL) S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            289 =>
            array(
                'id' => 290,
                'bank_name' => 'BANCO JOHN DEERE S.A.',
                'ispb' => '91884981',
                'code_number' => '217',
                'nome_extenso' => 'Banco John Deere S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            290 =>
            array(
                'id' => 291,
                'bank_name' => 'BCO DO ESTADO DO RS S.A.',
                'ispb' => '92702067',
                'code_number' => '41',
                'nome_extenso' => 'Banco do Estado do Rio Grande do Sul S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            291 =>
            array(
                'id' => 292,
                'bank_name' => 'ADVANCED CC LTDA',
                'ispb' => '92856905',
                'code_number' => '117',
                'nome_extenso' => 'ADVANCED CORRETORA DE CÂMBIO LTDA',
                'createtime' => NULL,
                'status' => NULL,
            ),
            292 =>
            array(
                'id' => 293,
                'bank_name' => 'BCO DIGIMAIS S.A.',
                'ispb' => '92874270',
                'code_number' => '654',
                'nome_extenso' => 'BANCO DIGIMAIS S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            293 =>
            array(
                'id' => 294,
                'bank_name' => 'WARREN CVMC LTDA',
                'ispb' => '92875780',
                'code_number' => '371',
                'nome_extenso' => 'WARREN CORRETORA DE VALORES MOBILIÁRIOS E CÂMBIO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            294 =>
            array(
                'id' => 295,
                'bank_name' => 'BANCO ORIGINAL',
                'ispb' => '92894922',
                'code_number' => '212',
                'nome_extenso' => 'Banco Original S.A.',
                'createtime' => NULL,
                'status' => NULL,
            ),
            295 =>
            array(
                'id' => 296,
                'bank_name' => 'DECYSEO CC LTDA.',
                'ispb' => '94968518',
                'code_number' => '289',
                'nome_extenso' => 'DECYSEO CORRETORA DE CAMBIO LTDA.',
                'createtime' => NULL,
                'status' => NULL,
            ),
        ));
    }
}
