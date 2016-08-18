<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <!--
    Режим отображения:
  -->
  <xsl:variable name="template_mode">
    <xsl:choose>
      <xsl:when test="/Root/Settings/@isWeb = '1'">web</xsl:when>
      <xsl:otherwise>client</xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <xsl:output method="html" indent="yes" encoding="windows-1251"
    doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
    doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" />
  <!-- <xsl:output method="html" indent="yes" encoding="utf-8" omit-xml-declaration="yes" standalone="yes" /> -->

  <!-- С расшифровкой в xml -->
  <xsl:variable name="with_description">
    <xsl:choose>
      <xsl:when test="/Root/Settings/@withDesc">
        <xsl:choose>
          <xsl:when test="/Root/Settings/@withDesc = '1'">1</xsl:when>
          <xsl:otherwise>0</xsl:otherwise>
        </xsl:choose>
      </xsl:when>
      <xsl:otherwise>
        <!-- Для интернета по любому работаем без внешних запросов (т.е. с расшифровкой в xml) -->
        <xsl:choose>
          <xsl:when test="$template_mode = 'web'">1</xsl:when>
          <xsl:otherwise>0</xsl:otherwise>
        </xsl:choose>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <!-- Для России  -->
  <xsl:variable name="for_russia">
    <xsl:choose>
      <xsl:when test="/Root/Settings/@isCountryRussia"><xsl:value-of select="/Root/Settings/@isCountryRussia"/></xsl:when>
      <xsl:otherwise>0</xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <!-- Определение числовых форматов -->
  <xsl:decimal-format name="format_settings" decimal-separator="." grouping-separator="&#160;" NaN=""/>
  <xsl:variable name="currency_format" select="'#0.00;-&#160;#0.00'"/>
  <xsl:variable name="currency_format_no_spaces" select="'#0.00'"/>

  <xsl:variable name="money_unit" select="/Root/Settings/@currency"/>
  <xsl:variable name="expanded" select="/Root/Settings/@expanded = '1'"/>
  <xsl:variable name="heading_expand" select="/Root/Settings/@headingExpand = '1'"/>
  <xsl:variable name="lang" select="/Root/Settings/@lang"/>

  <xsl:variable name="l_r_abon">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Абон.</xsl:when>
          <xsl:otherwise>Абон.</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_abon_full">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">зі слів Абонента</xsl:when>
          <xsl:otherwise>со слов Абонента</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_abon_pay_full">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">зі слів Абонента (з квитанції)</xsl:when>
          <xsl:otherwise>со слов Абонента (из квитанции)</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_abon_pay_symb" select="'А'"/>

  <xsl:variable name="l_r_abon_symb" select="'А'"/>

  <xsl:variable name="l_r_begin">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Початкове</xsl:when>
          <xsl:otherwise>Начальное</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_calc">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Розр.</xsl:when>
          <xsl:otherwise>Расч.</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_calc_full">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Розрахункове</xsl:when>
          <xsl:otherwise>Расчетное</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_calc_plan_full">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Розрахункове (прогноз)</xsl:when>
          <xsl:otherwise>Расчетное (прогноз)</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_calc_plan_symb" select="'Р'"/>

  <xsl:variable name="l_r_calc_symb" select="'Р'"/>

  <xsl:variable name="l_r_contr">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Контр.</xsl:when>
          <xsl:otherwise>Контр.</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_contr_full">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Контрольне</xsl:when>
          <xsl:otherwise>Контрольное</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_contr_symb" select="'К'"/>

  <xsl:variable name="l_r_end">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Кінцеве</xsl:when>
          <xsl:otherwise>Конечное</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_start_full">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Стартове (початкове)</xsl:when>
          <xsl:otherwise>Стартовое (начальное)</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="l_r_start_symb" select="'С'"/>

  <xsl:variable name="l_r_type">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Тип показань</xsl:when>
          <xsl:otherwise>Тип показаний</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="columns_for_readings">
    <xsl:choose>
      <xsl:when test="count(//Scale/ReadingEnd|//Scale/ReadingBeg) &gt; 1">2</xsl:when>
      <xsl:otherwise>0</xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <xsl:variable name="year">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">р</xsl:when>
          <xsl:otherwise>г</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

    <xsl:variable name="name_from">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">з</xsl:when>
            <xsl:otherwise>с</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_to">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">по</xsl:when>
            <xsl:otherwise>по</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_za">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">за</xsl:when>
            <xsl:otherwise>за</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_na">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">на</xsl:when>
            <xsl:otherwise>на</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_people">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">ос</xsl:when>
            <xsl:otherwise>чел</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_sum">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">сума</xsl:when>
            <xsl:otherwise>сумма</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>


  <!-- Надо ли отображать колонку для суммы начислений без компенасации -->
  <xsl:variable name="fee_wo_compens">
        <xsl:value-of select="$for_russia = 1 and count(/Root/CommonCard/CommonCardData/CommonCardYears/Year/Month/Service/@feeSumWoCompens) > 0" />
  </xsl:variable>

  <!--
    Общее количество колонок в таблице с данными
  -->
  <xsl:variable name="total_columns_static">
    <xsl:choose>
      <xsl:when test="$for_russia = '1'">8</xsl:when>
      <xsl:otherwise>7</xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <!-- Количество колонок для льгот -->
  <!-- На переходный момент оставляем проверку и по признаку Россия ли. В перспективе за это будет отвечать атрибут withPrivel -->
  <xsl:variable name="columns_for_privel">
    <xsl:choose>
      <xsl:when test="/Root/Settings/@withPrivel='1'">2</xsl:when>
      <xsl:when test="/Root/Settings/@withPrivel='0'">0</xsl:when>
      <xsl:otherwise>
        <xsl:choose>
          <xsl:when test="$for_russia='1'">0</xsl:when>
          <xsl:otherwise>2</xsl:otherwise>
        </xsl:choose>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <xsl:variable name="total_columns_count">
    <xsl:choose>
      <xsl:when test="$fee_wo_compens = 'true'">
        <xsl:value-of select="$columns_for_readings + $total_columns_static + $columns_for_privel + 1"/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$columns_for_readings + $total_columns_static + $columns_for_privel"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:variable>

  <!-- ######################################################################## -->

  <xsl:template match="Root">
    <xsl:choose>
      <xsl:when test="$template_mode = 'client'"><xsl:call-template name="full_template_mode"/></xsl:when>
      <xsl:when test="$template_mode = 'web'"><xsl:call-template name="short_template_mode"/></xsl:when>
      <xsl:otherwise>UNKNOW TEMPLATE MODE SELECTED</xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:variable name="card_title">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Загальна картка</xsl:when>
          <xsl:otherwise>Общая карточка</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="labels_meaning">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Мітки на краях полів "Показання лічильника" означають, що в періоді є:</xsl:when>
          <xsl:otherwise>Метки на краях полей "Показания счетчика" обозначают, что в периоде имеются:</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="labels_meaning_contr">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">контрольні показання</xsl:when>
          <xsl:otherwise>контрольные показания</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="labels_meaning_abon">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">показання абонента</xsl:when>
          <xsl:otherwise>показания абонента</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template name="full_template_mode">
    <html>
      <head>
        <meta http-equiv="Content-Language" content="ru"/>
        <title><xsl:value-of select="$card_title"/></title>
        <xsl:call-template name="styles"/>
      </head>
      <body>
        <xsl:apply-templates select="CommonCard/ClientInfo"/>
        <p style="font-size: smaller; color: #888; margin:0 5px;">
          <xsl:value-of select="$labels_meaning"/>
          <span class="contr-r">*</span> - <xsl:value-of select="$labels_meaning_contr"/>;
          <span class="abon-r">*</span> - <xsl:value-of select="$labels_meaning_abon"/>.
        </p>
        <xsl:call-template name="short_template_mode"/>
      </body>
    </html>
  </xsl:template>


  <xsl:template name="short_template_mode">
    <xsl:apply-templates select="CommonCard/CommonCardData"/>
    <script type="text/javascript">
      <xsl:text>with_external_requests=</xsl:text>
      <xsl:choose>
        <xsl:when test="$with_description = '1'">false;</xsl:when>
        <xsl:otherwise>true;</xsl:otherwise>
      </xsl:choose>
      <!-- client_template_mode -->
      <xsl:text>client_template_mode=</xsl:text>
      <xsl:choose>
        <xsl:when test="$template_mode = 'client'">true;</xsl:when>
        <xsl:otherwise>false;</xsl:otherwise>
      </xsl:choose>
      <!-- expanded -->
      <xsl:text>expanded=</xsl:text>
      <xsl:value-of select="$expanded" />
      <xsl:text>;</xsl:text>
      <!-- heading_expand -->
      <xsl:text>heading_expand=</xsl:text>
      <xsl:value-of select="$heading_expand" />
      <xsl:text>;</xsl:text>
    </script>
    <xsl:call-template name="scripts"/>
  </xsl:template>


  <xsl:template name="btn">
    <xsl:param name="src" />
    <xsl:param name="class" />
    <xsl:param name="id" />
    <xsl:param name="content" />
    <xsl:choose>
      <xsl:when test="$template_mode = 'web'">
        <i>
          <xsl:if test="$id!=''"><xsl:attribute name="id"><xsl:value-of select="$id" /></xsl:attribute></xsl:if>
          <xsl:if test="$class!=''"><xsl:attribute name="class"><xsl:value-of select="$class" /></xsl:attribute></xsl:if>
          <xsl:value-of select="$content" />
        </i>
      </xsl:when>
      <xsl:otherwise>
        <img>
          <xsl:if test="$id!=''"><xsl:attribute name="id"><xsl:value-of select="$id" /></xsl:attribute></xsl:if>
          <xsl:if test="$src!=''"><xsl:attribute name="src"><xsl:value-of select="$src" /></xsl:attribute></xsl:if>
          <xsl:if test="$class!=''"><xsl:attribute name="class"><xsl:value-of select="$class" /></xsl:attribute></xsl:if>
          <xsl:if test="$content!=''"><xsl:attribute name="alt"><xsl:value-of select="$content" /></xsl:attribute></xsl:if>
        </img>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>



  <xsl:variable name="client_info_hist_card">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Історична картка станом на</xsl:when>
          <xsl:otherwise>Историческая карточка по состоянию на</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_acc">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Особовий рахунок</xsl:when>
          <xsl:otherwise>Лицевой счет</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_addr">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Адреса</xsl:when>
          <xsl:otherwise>Адрес</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_phone">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Телефон</xsl:when>
          <xsl:otherwise>Телефон</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_tarif_type">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Тип тарифу</xsl:when>
          <xsl:otherwise>Тип тарифа</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_counter">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Лічильник</xsl:when>
          <xsl:otherwise>Счетчик</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="ClientInfo">
    <xsl:if test="/Root/CommonCard/@dategen">
        <div style="text-align: center;">
            <strong style="color: #f00; font-family: verdana,tahoma;">
            <xsl:value-of select="$client_info_hist_card"/> <xsl:value-of select="/Root/CommonCard/@dategen"/>
            </strong>
        </div>
    </xsl:if>
    <table id="table_summary" cellpadding="0" cellspacing="0" class="summary">
      <tbody id="abcode_short_info" class="hide_node">
        <tr>
          <th><xsl:value-of select="$client_info_acc"/></th>
          <td>
            <ul>
              <li>
                <strong>№ <xsl:value-of select="@abcode"/></strong>
                <xsl:text>, </xsl:text>
                <xsl:value-of select="@fio"/>
                <!-- <i id="show_abcode_details" class="cc_closed">+</i> -->
                <!-- <img src="cc1.gif" alt="[*]"  id="show_abcode_details"/> -->
                <xsl:call-template name="btn">
                  <xsl:with-param name="src" select="'cc1.gif'"/>
                  <!-- <xsl:with-param name="class" /> -->
                  <xsl:with-param name="id" select="'show_abcode_details'" />
                  <xsl:with-param name="content" select="'+'"/>
                </xsl:call-template>
              </li>
            </ul>
          </td>
        </tr>
      </tbody>

      <tbody id="abcode_details">
        <tr>
          <th><xsl:value-of select="$client_info_acc"/></th>
          <td>
            <ul>
              <li>
                <strong>№ <xsl:value-of select="@abcode"/></strong>
                <xsl:text> </xsl:text>
                <!-- <i id="hide_abcode_details" class="cc_opened">-</i> -->
                <!-- <img src="cc2.gif" alt="[*]" id="hide_abcode_details"/> -->
                <xsl:call-template name="btn">
                  <xsl:with-param name="src" select="'cc2.gif'"/>
                  <xsl:with-param name="class" select="'cc_opened'" />
                  <xsl:with-param name="id" select="'hide_abcode_details'" />
                  <xsl:with-param name="content" select="'-'"/>
                </xsl:call-template>
              </li>
            </ul>
          </td>
        </tr>
        <tr>
          <th>&#160;</th>
          <td>
            <ul>
              <li>
                <xsl:value-of select="@fio"/>
              </li>
              <li>
                <xsl:value-of select="$client_info_addr"/>: <xsl:value-of select="@address"/>
              </li>
              <xsl:if test="@phone">
                <li>
                  <xsl:value-of select="$client_info_phone"/>: <xsl:value-of select="@phone"/>
                </li>
              </xsl:if>
            </ul>
          </td>
        </tr>
        <xsl:apply-templates select="*"/>
      </tbody>
    </table>
  </xsl:template>


    <xsl:template name="set-row-class">
        <xsl:if test="position() mod 2 != 0">
            <xsl:attribute name="class">altrow</xsl:attribute>
        </xsl:if>
    </xsl:template>

    <xsl:template match="ClientInfo/TarifTypes">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$client_info_tarif_type"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="TarifTypes/Item">
        <li>
            <xsl:value-of select="@name"/>
        </li>
    </xsl:template>


    <xsl:template match="ClientInfo/Counters">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$client_info_counter"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

  <xsl:variable name="client_info_counter_number">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">номер</xsl:when>
          <xsl:otherwise>номер</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_counter_type">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">тип</xsl:when>
          <xsl:otherwise>тип</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_counter_setup">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">встановлений</xsl:when>
          <xsl:otherwise>установлен</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_counter_check">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">наступна держповірка</xsl:when>
          <xsl:otherwise>следующая госповерка</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="client_info_counter_ood">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">ПРОСТРОЧЕНА</xsl:when>
          <xsl:otherwise>ПРОСРОЧЕНА</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

    <xsl:template match="Counters/Counter">
        <li>
            <xsl:value-of select="@serviceName"/>
            <xsl:text>, </xsl:text><xsl:value-of select="@topologyName"/>
            <xsl:text>, </xsl:text><xsl:value-of select="$client_info_counter_number"/>
            <xsl:text> </xsl:text><xsl:value-of select="@number"/>
            <xsl:text>, </xsl:text><xsl:value-of select="$client_info_counter_type"/>
            <xsl:text> </xsl:text><xsl:value-of select="@model"/>
            <xsl:text>, </xsl:text><xsl:value-of select="$client_info_counter_setup"/>
            <xsl:text> </xsl:text><xsl:value-of select="@dateMount"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:if test="@dateNextGosp">
                <xsl:text>, </xsl:text><xsl:value-of select="$client_info_counter_check"/>
                <xsl:text> </xsl:text><xsl:value-of select="@dateNextGosp"/>
                <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            </xsl:if>
            <xsl:if test="@gospAlert">
                <xsl:text> </xsl:text><xsl:value-of select="$client_info_counter_ood"/><xsl:text>! </xsl:text>
            </xsl:if>
        </li>
    </xsl:template>


  <xsl:variable name="contract_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Угода</xsl:when>
          <xsl:otherwise>Договор</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

    <xsl:template match="ClientInfo/Contracts">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$contract_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>


<!--
  значения typecontract :
    0 - коммунальные услуги,
    1 - SMS,
    2 - интернет
-->
    <xsl:variable name="contract_type_1">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">на SMS-послуги</xsl:when>
            <xsl:otherwise>на SMS-услуги</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="contract_type_2">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">на інтернет-послуги</xsl:when>
            <xsl:otherwise>на интернет-услуги</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="contract_date">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">дата укладення</xsl:when>
            <xsl:otherwise>дата заключения</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="contract_close">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">закрытий</xsl:when>
            <xsl:otherwise>закрыт</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="Contracts/Contract">
        <xsl:variable name="typecontract" select="@typecontract"/>
        <li>
            <xsl:choose>
                <xsl:when test="$typecontract = 0"/>
                <xsl:when test="$typecontract = 1"><xsl:value-of select="$contract_type_1"/>, </xsl:when>
                <xsl:when test="$typecontract = 2"><xsl:value-of select="$contract_type_2"/>, </xsl:when>
                <xsl:otherwise/>
            </xsl:choose>
            <xsl:value-of select="$contract_date"/>
            <xsl:text> </xsl:text><xsl:value-of select="@dateBegin"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:if test="@dateEnd">
                <xsl:text>, </xsl:text><xsl:value-of select="$contract_close"/>
                <xsl:text> </xsl:text><xsl:value-of select="@dateEnd"/>
                <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            </xsl:if>
        </li>
    </xsl:template>


<!--
  <ViolationActs>
    <Act number="07316" dateAct="2006-05-04" paySum="1411.85" debitSum="0.00" codeViolation="1" nameViolation="" />
  </ViolationActs>
-->
    <xsl:variable name="act_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Акт</xsl:when>
            <xsl:otherwise>Акт</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="act_period_start">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">за період з</xsl:when>
            <xsl:otherwise>за период с</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="act_period_to">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">по</xsl:when>
            <xsl:otherwise>по</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="act_pay">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">до сплати</xsl:when>
            <xsl:otherwise>к оплате</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="act_debt">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">заборгованість</xsl:when>
            <xsl:otherwise>задолженность</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="act_reason">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">за порушення</xsl:when>
            <xsl:otherwise>за нарушение</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/ViolationActs">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$act_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="ViolationActs/Act">
        <li>
            <xsl:text>№ </xsl:text><xsl:value-of select="@number"/>
            <xsl:text> </xsl:text><xsl:value-of select="$act_period_start"/>
            <xsl:text> </xsl:text><xsl:value-of select="@dateBegin"/>
            <xsl:text> </xsl:text><xsl:value-of select="$act_period_to"/>
            <xsl:text> </xsl:text><xsl:value-of select="@dateEnd"/>
            <xsl:if test="@sumact">
                <xsl:text>, </xsl:text><xsl:value-of select="$act_pay"/>
                <xsl:text> </xsl:text><xsl:value-of select="@sumact"/>
                <xsl:text> </xsl:text><xsl:value-of select="$money_unit"/>
                <xsl:text>, </xsl:text><xsl:value-of select="$act_debt"/>
                <xsl:text> </xsl:text><xsl:value-of select="@sumdebt"/>
                <xsl:text> </xsl:text><xsl:value-of select="$money_unit"/>
            </xsl:if>
            <xsl:text>, </xsl:text><xsl:value-of select="$act_reason"/>
            <xsl:text>: </xsl:text><xsl:value-of select="@nameViolation"/>
        </li>
    </xsl:template>

<!--
    <BypassResults>
      <Bypass date="2006-05-04" result="1111" controllerName="qwe" />
      <Bypass date="2006-05-04" result="22222" controllerName="asd" />
    </BypassResults>
-->
    <xsl:variable name="bypass_res_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Результати обходу</xsl:when>
            <xsl:otherwise>Результати обходу</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="bypass_res_date">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">дата</xsl:when>
            <xsl:otherwise>дата</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="bypass_res_res">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">результат</xsl:when>
            <xsl:otherwise>результат</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="bypass_res_contr">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">контролер</xsl:when>
            <xsl:otherwise>контролер</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/BypassResults">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$bypass_res_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="BypassResults/Bypass">
        <li>
            <xsl:value-of select="$bypass_res_date"/>
            <xsl:text> </xsl:text><xsl:value-of select="@date"/>
            <xsl:text> &#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:text>, </xsl:text><xsl:value-of select="$bypass_res_res"/><xsl:text>: </xsl:text>
            <xsl:value-of select="@result"/>
            <xsl:text>, </xsl:text><xsl:value-of select="$bypass_res_contr"/><xsl:text>: </xsl:text>
            <xsl:value-of select="@controllerName"/>
        </li>
    </xsl:template>

<!--
    <Requests>
      <Request number="222" typeName="" sum="50.00" stateCode="A" stateName="name" dateExecute="2006-05-04"/>
      <Request number="333" typeName="" sum="30.00" stateCode="B" stateName="name" dateExecute="2006-05-04"/>
    </Requests>
-->
    <xsl:variable name="request_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Запит</xsl:when>
            <xsl:otherwise>Заявка</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/Requests">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$request_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="Requests/Request">
        <li>
            <xsl:text>№ </xsl:text>
            <xsl:value-of select="@number"/>
            <xsl:value-of select="@typeName"/>
            <xsl:text>, </xsl:text>
            <xsl:value-of select="@sum"/>
            <xsl:text> </xsl:text>
            <xsl:value-of select="$money_unit"/>
            <xsl:text>, на </xsl:text>
            <xsl:value-of select="@dateExecute"/>
            <xsl:text> &#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:value-of select="@stateName"/>
        </li>
    </xsl:template>


    <xsl:variable name="cutoff_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Відключення</xsl:when>
            <xsl:otherwise>Отключения</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>


    <xsl:template match="ClientInfo/Cutoffs">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$cutoff_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="Cutoffs/Cutoff">
        <li>
            <xsl:value-of select="@name"/>
            <xsl:text> </xsl:text><xsl:value-of select="$name_from"/>
            <xsl:text> </xsl:text><xsl:value-of select="@dateBegin"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:text> </xsl:text><xsl:value-of select="$name_to"/>
            <xsl:text> </xsl:text><xsl:value-of select="@dateEnd"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
        </li>
    </xsl:template>


    <xsl:variable name="revise_clients_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Контроль розрахунків</xsl:when>
            <xsl:otherwise>Контроль расчетов</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="revise_clients_item">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Коректність сальдо підтверджена</xsl:when>
            <xsl:otherwise>Корректность сальдо подтверждена</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/ReviseClients">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$revise_clients_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="ReviseClients/Item">
        <li>
            <xsl:value-of select="$revise_clients_item"/><xsl:text>: </xsl:text>
            <xsl:value-of select="@date"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
        </li>
    </xsl:template>


    <!--
    <ClientParams>
      <Param name="проживающие" value="1" dateBegin="2006-05-04" />
      <Param name="счета" value="2" dateBegin="2006-05-04" />
    </ClientParams>
-->
    <xsl:variable name="parameters_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Параметри</xsl:when>
            <xsl:otherwise>Параметры</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/ClientParams">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$parameters_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="ClientParams/Param">
        <li>
            <xsl:value-of select="@name"/>
            <xsl:text> (</xsl:text>
            <xsl:value-of select="@value"/>
            <xsl:text> </xsl:text><xsl:value-of select="$name_from"/><xsl:text> </xsl:text>
            <xsl:value-of select="@dateBegin"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:text>)</xsl:text>
        </li>
    </xsl:template>

    <!--
    <Privileges>
      <Privilege name="Ветеран ВОВ" percent="50" count="1" limit="75" dateBegin="2006-05-04"/>
      <Privilege name="Ветеран ВОВ" percent="50" count="1" limit="75" dateBegin="2006-05-04"/>
    </Privileges>
-->
    <xsl:variable name="privileges_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Пільги</xsl:when>
            <xsl:otherwise>Льготы</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="privileges_limit">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">ліміт</xsl:when>
            <xsl:otherwise>лимит</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/Privileges">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$privileges_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>


    <xsl:template match="Privileges/Privilege">
        <li>
            <xsl:value-of select="@name"/>
            <xsl:text> </xsl:text>
            <xsl:value-of select="@percent"/>
            <xsl:text>%, </xsl:text>
            <xsl:value-of select="@count"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$name_people"/><xsl:text>.</xsl:text>
            <xsl:if test="@limit">
                <xsl:text>, </xsl:text><xsl:value-of select="$privileges_limit"/><xsl:text> </xsl:text>
                <xsl:value-of select="@limit"/>
            </xsl:if>
            <xsl:text>, </xsl:text><xsl:value-of select="$name_from"/><xsl:text> </xsl:text>
            <xsl:value-of select="@dateBegin"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
        </li>
    </xsl:template>

    <!--
    <GraphPays>
      <Item isForAct="true" dateBegin="2006-05-04" dateEnd="2006-05-04" sum="231" />
    </GraphPays>
-->
    <xsl:variable name="graph_pays_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Графік погашення</xsl:when>
            <xsl:otherwise>График погашения</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="graph_pays_act">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">за актом</xsl:when>
            <xsl:otherwise>по акту</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/GraphPays">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$graph_pays_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>


    <xsl:template match="GraphPays/Item">
        <li>
            <xsl:text> </xsl:text><xsl:value-of select="$name_from"/><xsl:text> </xsl:text>
            <xsl:value-of select="@dateBegin"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:text> </xsl:text><xsl:value-of select="$name_to"/><xsl:text> </xsl:text>
            <xsl:value-of select="@dateEnd"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
            <xsl:text> </xsl:text><xsl:value-of select="$name_sum"/><xsl:text>: </xsl:text>
            <xsl:value-of select="@sum"/>
            <xsl:text>&#160;</xsl:text>
            <xsl:value-of select="$money_unit"/>
            <xsl:text> </xsl:text>
            <xsl:if test="@isForAct = 'true'">
                <xsl:text> (</xsl:text><xsl:value-of select="$graph_pays_act"/><xsl:text>)</xsl:text>
            </xsl:if>
        </li>
    </xsl:template>

<!--
    <Equipments>
  <Equipment name="котел" dateBegin="04.05.2006"/>
    </Equipments>
-->
    <xsl:variable name="equipments_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Обладнання</xsl:when>
            <xsl:otherwise>Оборудование</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/Equipments">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$equipments_name"/>
            </th>
            <td>
                <ul>
                    <xsl:apply-templates/>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="Equipments/Equipment">
        <li>
            <xsl:value-of select="@name"/>
            <xsl:if test="@value">
                <xsl:text>, </xsl:text>
                <xsl:value-of select="@value"/>
                <xsl:text> </xsl:text>
                <xsl:value-of select="@unit"/>
            </xsl:if>
            <xsl:text>, </xsl:text><xsl:value-of select="$name_from"/><xsl:text> </xsl:text>
            <xsl:value-of select="@dateBegin"/>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
        </li>
    </xsl:template>

    <xsl:variable name="tarif_per_people_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Вартість на 1 ос</xsl:when>
            <xsl:otherwise>Стоимость на 1 чел</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="tarif_per_people_garbage">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">вартість вивезення поб.відходів на 1 ос. в місяць (без урахування пільг)</xsl:when>
            <xsl:otherwise>стоимость вывоза быт.отходов на 1 чел. в месяц (без учета льгот)</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/WasteTarifPerPeople">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$tarif_per_people_name"/><xsl:text>.</xsl:text>
            </th>
            <td>
                <ul>
        <li>
      <xsl:value-of select="$tarif_per_people_garbage"/><xsl:text>: </xsl:text>
      <xsl:value-of select="@tarif"/>&#160;<xsl:value-of select="$money_unit"/>
        </li>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <!--
      <Norma indNorma"123.22 кВт*ч" odnNorma="1.12 кВт*ч/м2" />
    -->
    <xsl:variable name="norma_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Норматив</xsl:when>
            <xsl:otherwise>Норматив</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="norma_ind">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">індивідуальний</xsl:when>
            <xsl:otherwise>индивидуальный</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="norma_month">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">на місяць</xsl:when>
            <xsl:otherwise>в месяц</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="norma_needs">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">на ЗБП</xsl:when>
            <xsl:otherwise>на ОДН</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/Norma">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$norma_name"/>
            </th>
            <td>
                <ul>
                    <li>
                        <xsl:value-of select="$norma_ind"/><xsl:text>: </xsl:text><xsl:value-of select="@indNorma"/>
                        <xsl:text> </xsl:text><xsl:value-of select="$norma_month"/><xsl:text>, </xsl:text>
                        <xsl:value-of select="$norma_needs"/><xsl:text>: </xsl:text><xsl:value-of select="@odnNorma"/>
                    </li>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <!--
      <CurrentSaldo sumSaldo="12"/>
    -->
    <xsl:variable name="saldo_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Сальдо</xsl:when>
            <xsl:otherwise>Сальдо</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="sum_fine_in_saldo_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">в т.ч. пені на суму</xsl:when>
            <xsl:otherwise>в т.ч. пени на сумму</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/CurrentSaldo">
        <tr>
            <xsl:call-template name="set-row-class"/>
            <th>
                <xsl:value-of select="$saldo_name"/>
            </th>
            <td>
                <ul>
                    <li>
                        <xsl:value-of select="@sumSaldo"/>&#160;<xsl:value-of select="$money_unit"/>
                        <xsl:apply-templates select="@sumSaldoFine" mode="current_saldo"/>
                    </li>
                </ul>
            </td>
        </tr>
    </xsl:template>

    <xsl:template match="@sumSaldoFine" mode="current_saldo" >
        <xsl:text>, </xsl:text><xsl:value-of select="$sum_fine_in_saldo_name"/>
        <xsl:text>: </xsl:text><xsl:value-of select="."/>&#160;<xsl:value-of select="$money_unit"/>
    </xsl:template>

    <xsl:variable name="note_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Примітка</xsl:when>
            <xsl:otherwise>Примечание</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="ClientInfo/ClientNote">
        <xsl:choose>
            <xsl:when test="@text != ''">
                <tr>
                    <xsl:call-template name="set-row-class"/>
                    <th>
                        <xsl:value-of select="$note_name"/>
                    </th>
                    <td>
                        <ul>
                            <li><xsl:value-of select="@text"/></li>
                        </ul>
                    </td>
                </tr>
            </xsl:when>
            <xsl:otherwise></xsl:otherwise>
        </xsl:choose>
    </xsl:template>

<!-- ######################################################## CommonCardData ## -->

<!--
  Данные общей карточки - таблица
-->
  <xsl:template match="CommonCardData">
    <table cellpadding="0" cellspacing="0" class="data common_card" id="commonCardData">
      <xsl:call-template name="CommonCardTable_header" />
      <tfoot>
        <xsl:apply-templates select="BeginingSaldo|LastRevisionAct" />
      </tfoot>
      <tbody>
        <xsl:apply-templates select="CommonCardYears"/>
      </tbody>
    </table>
  </xsl:template>

<!--
  шапка таблицы с данными
-->
    <xsl:variable name="month_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Місяць</xsl:when>
            <xsl:otherwise>Месяц</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="service_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Послуга</xsl:when>
            <xsl:otherwise>Услуга</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="counter_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Показання лічильника</xsl:when>
            <xsl:otherwise>Показания счетчика</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="charge_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Нараховано</xsl:when>
            <xsl:otherwise>Начислено</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="charge_ind_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">індивид.</xsl:when>
            <xsl:otherwise>индивид.</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="amount_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">кіл-ть</xsl:when>
            <xsl:otherwise>кол-во</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="consumption_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">споживання</xsl:when>
            <xsl:otherwise>потребление</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="charge_odn_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Нараховано ЗБП</xsl:when>
            <xsl:otherwise>Начислено ОДН</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="no_comp_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">без&#160;компенс.</xsl:when>
            <xsl:otherwise>без&#160;компенс.</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="payment_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Сплата</xsl:when>
            <xsl:otherwise>Оплата</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="subs_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Субсидія</xsl:when>
            <xsl:otherwise>Субсидия</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="debt_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Борг</xsl:when>
            <xsl:otherwise>Долг</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="prepaid_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Аванс</xsl:when>
            <xsl:otherwise>Аванс</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="start_val_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">початкове</xsl:when>
            <xsl:otherwise>начальное</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="end_val_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">кінцеве</xsl:when>
            <xsl:otherwise>конечное</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="total_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">разом</xsl:when>
            <xsl:otherwise>всего</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="Total_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Разом</xsl:when>
            <xsl:otherwise>Всего</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="dot_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">дотація</xsl:when>
            <xsl:otherwise>дотация</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="tarif_name">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Тариф</xsl:when>
            <xsl:otherwise>Тариф</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

  <xsl:template name="CommonCardTable_header">
    <thead>
      <tr>
        <th rowspan="2"><xsl:value-of select="$month_name"/></th>
        <th rowspan="2"><xsl:value-of select="$service_name"/></th>
        <xsl:if test="$columns_for_readings &gt; 0">
          <th colspan="2"><xsl:value-of select="$counter_name"/></th>
        </xsl:if>

        <th>
          <xsl:choose>
            <xsl:when test="$columns_for_privel &gt; 0">
              <xsl:attribute name="colspan">2</xsl:attribute>
            </xsl:when>
            <xsl:otherwise>
              <xsl:attribute name="rowspan">2</xsl:attribute>
            </xsl:otherwise>
          </xsl:choose>
          <xsl:choose>
            <xsl:when test="$for_russia='1'">
                <xsl:value-of select="$charge_name"/>
                <br/> <xsl:value-of select="$consumption_name"/>,<br/> <xsl:value-of select="$amount_name"/>
            </xsl:when>
            <xsl:otherwise><xsl:value-of select="$charge_name"/>, <br/><xsl:value-of select="$amount_name"/></xsl:otherwise>
          </xsl:choose>
        </th>

        <xsl:if test="$for_russia='1'">
          <th rowspan="2"><xsl:value-of select="$charge_odn_name"/>,<br/> <xsl:value-of select="$amount_name"/></th>
        </xsl:if>

        <th rowspan="2">
          <xsl:value-of select="$tarif_name"/>, <xsl:value-of select="$money_unit"/>
        </th>
        <xsl:if test="$fee_wo_compens = 'true'">
          <th rowspan="2"><xsl:value-of select="$charge_name"/><br/><xsl:value-of select="$charge_name"/>,<br/><xsl:value-of select="$money_unit"/></th>
        </xsl:if>
        <th rowspan="2">
          <xsl:value-of select="$Total_name"/><br/><xsl:value-of select="$charge_name"/>, <xsl:value-of select="$money_unit"/>
        </th>
        <th rowspan="2"><xsl:value-of select="$payment_name"/>, <xsl:value-of select="$money_unit"/></th>
        <xsl:if test="$columns_for_privel &gt; 0">
          <th rowspan="2"><xsl:value-of select="$subs_name"/>, <xsl:value-of select="$money_unit"/></th>
        </xsl:if>
        <th rowspan="2"><xsl:value-of select="$debt_name"/>&#160;(+)<br/> <xsl:value-of select="$prepaid_name"/>&#160;(-)</th>
      </tr>
      <tr>
        <xsl:if test="$columns_for_readings &gt; 0">
          <th><xsl:value-of select="$start_val_name"/></th>
          <th><xsl:value-of select="$end_val_name"/></th>
        </xsl:if>
        <xsl:if test="$columns_for_privel &gt; 0">
          <th><xsl:value-of select="$total_name"/></th>
          <th><xsl:value-of select="$dot_name"/></th>
        </xsl:if>
      </tr>
    </thead>
  </xsl:template>

  <xsl:template match="CommonCardYears">
    <xsl:apply-templates select="Year" />
  </xsl:template>


<!--
  (TR)
  Шаблон для всех дочерних элементов узла CommonCardYears.
  Каждый элемент рисуем в строке таблицы.
  Если какой то узел нуждается в ином подходе - ниже будем описывать его специфику типа:
  <xsl:template match="CommonCardYears//Top">...</xsl:template>
-->
  <xsl:template match="CommonCardYears//*">
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="parent_class"/>
    <xsl:param name="freeze_parent_class" select="'False'" />
    <xsl:variable name="node_class">
      <xsl:choose>
        <xsl:when test="$freeze_parent_class = 'True'"><xsl:value-of select="$parent_class"/></xsl:when>
        <xsl:otherwise><xsl:value-of select="concat($parent_class, '_', position())"/></xsl:otherwise>
      </xsl:choose>
    </xsl:variable>

    <xsl:if test="position() &gt; 1">
      <xsl:apply-templates select="." mode="apply_templates_before">
        <xsl:with-param name="level" select="$level"/>
        <xsl:with-param name="node_class" select="$node_class"/>
      </xsl:apply-templates>
    </xsl:if>

    <tr>
      <xsl:call-template name="set_class_for_row">
        <xsl:with-param name="level" select="$level"/>
        <xsl:with-param name="node_class" select="$node_class"/>
      </xsl:call-template>
      <xsl:apply-templates select="." mode="row_content">
        <xsl:with-param name="level" select="$level"/>
        <xsl:with-param name="node_class" select="$node_class"/>
      </xsl:apply-templates>
    </tr>

    <xsl:apply-templates select="." mode="external_info_container">
      <xsl:with-param name="level" select="$level"/>
      <xsl:with-param name="node_class" select="$node_class"/>
    </xsl:apply-templates>

    <xsl:apply-templates select="." mode="apply_templates">
      <xsl:with-param name="level" select="$level"/>
      <xsl:with-param name="node_class" select="$node_class"/>
    </xsl:apply-templates>
  </xsl:template>

<!--
  Продолжаем обрабатывать дочерние узлы
-->
<xsl:template match="*" mode="apply_templates">
  <xsl:param name="level">0</xsl:param>
  <xsl:param name="node_class" />
  <xsl:apply-templates select="./*">
    <xsl:with-param name="level"><xsl:value-of select="$level + 1"/></xsl:with-param>
    <xsl:with-param name="parent_class"><xsl:value-of select="$node_class"/></xsl:with-param>
  </xsl:apply-templates>
</xsl:template>


  <xsl:template match="*" mode="apply_templates_before"/>

  <xsl:variable name="StartVal_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Поч.показ.</xsl:when>
          <xsl:otherwise>Нач.показ.</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="EndVal_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Кін.показ.</xsl:when>
          <xsl:otherwise>Кон.показ.</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="Chrg_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Нарах.</xsl:when>
          <xsl:otherwise>Начис.</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="Dot_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Дотація</xsl:when>
          <xsl:otherwise>Дотация</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="amt_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">кіл</xsl:when>
          <xsl:otherwise>кол</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="ODN_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">ЗБП</xsl:when>
          <xsl:otherwise>ОДН</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="NoComp_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Без компенс.</xsl:when>
          <xsl:otherwise>Без компенс.</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="Year" mode="apply_templates_before">
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="node_class" />
    <tr>
      <xsl:call-template name="set_class_for_row">
        <xsl:with-param name="node_class"><xsl:value-of select="concat($node_class, '_0')"/></xsl:with-param>
      </xsl:call-template>
      <th><xsl:value-of select="$month_name"/></th>
      <th><xsl:value-of select="$service_name"/></th>
      <xsl:if test="$columns_for_readings &gt; 0">
        <th><xsl:value-of select="$StartVal_name"/></th>
        <th><xsl:value-of select="$EndVal_name"/></th>
      </xsl:if>
      <th><xsl:value-of select="$Chrg_name"/>, <xsl:value-of select="$amt_name"/></th>
      <xsl:if test="$columns_for_privel&gt;0">
        <th><xsl:value-of select="$Dot_name"/></th>
      </xsl:if>
      <xsl:if test="$for_russia='1'">
        <th><xsl:value-of select="$ODN_name"/></th>
      </xsl:if>
      <th><xsl:value-of select="$tarif_name"/></th>
      <xsl:if test="$fee_wo_compens = 'true'">
        <th><xsl:value-of select="$NoComp_name"/></th>
      </xsl:if>
      <th><xsl:value-of select="$Chrg_name"/>, <xsl:value-of select="$money_unit"/></th>
      <th><xsl:value-of select="$payment_name"/></th>
      <xsl:if test="$columns_for_privel&gt;0">
        <th><xsl:value-of select="$subs_name"/></th>
      </xsl:if>
      <th><xsl:value-of select="$debt_name"/>&#160;(+)</th>
    </tr>
  </xsl:template>


  <!--
    Начальное сальдо
  -->
  <xsl:variable name="BeginingSaldo_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Вхідне сальдо на</xsl:when>
          <xsl:otherwise>Входящее сальдо на</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="BeginingSaldoReading_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">показання</xsl:when>
          <xsl:otherwise>показания</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="kWh_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">кВт*г</xsl:when>
          <xsl:otherwise>кВт*ч</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="BeginingSaldo">
    <tr class="BeginingSaldo total">
      <td>
        <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count - 1"/></xsl:attribute>

        <xsl:value-of select="$BeginingSaldo_name"/><xsl:text> </xsl:text>
        <xsl:call-template name="formatdate">
          <xsl:with-param name="datestr" select="@date" />
        </xsl:call-template>
        <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/>

        <xsl:apply-templates select="Reading" />
        <xsl:text>:</xsl:text>
      </td>
      <td class="number nowrap">
        <xsl:value-of select="@sum"/>
      </td>
    </tr>
  </xsl:template>

  <xsl:template match="BeginingSaldo/Reading">
    <xsl:text> (</xsl:text><xsl:value-of select="$BeginingSaldoReading_name"/><xsl:text>: </xsl:text>
    <xsl:apply-templates select="Scale" />
    <xsl:text> </xsl:text><xsl:value-of select="$kWh_name"/><xsl:text>)</xsl:text>
  </xsl:template>


  <!--
    Акт сверки
  -->
  <xsl:variable name="LastRevisionAct_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Акт звірки складено</xsl:when>
          <xsl:otherwise>Акт сверки составлен</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="LastRevisionAct_overpmt">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Вхідна переплата на</xsl:when>
          <xsl:otherwise>Входящая переплата на</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="LastRevisionAct_debt">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Вхідна заборгованість на</xsl:when>
          <xsl:otherwise>Входящая задолженность на</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="LastRevisionAct_reading">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">по показання</xsl:when>
          <xsl:otherwise>по показание</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="LastRevisionAct">
  <tr class="LastRevisionAct total">
    <td>
      <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count - 1"/></xsl:attribute>

      <xsl:value-of select="$LastRevisionAct_name"/><xsl:text> </xsl:text>
      <xsl:call-template name="formatdate">
        <xsl:with-param name="datestr" select="@dateCreate" />
      </xsl:call-template>
      <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/><xsl:text> </xsl:text>
      <xsl:value-of select="$name_na"/><xsl:text>&#160;</xsl:text>
      <xsl:call-template name="formatdate">
        <xsl:with-param name="datestr" select="@dateRevisionAt" />
      </xsl:call-template>
      <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/>
      <xsl:apply-templates select="Reading" />
      <xsl:text>&#160;</xsl:text><xsl:value-of select="$kWh_name"/><xsl:text>.</xsl:text>

      <xsl:choose>
        <xsl:when test="$template_mode = 'web'">
          <br/>
          <b>
            <xsl:choose>
              <xsl:when test="number(@sum) &lt; 0"><xsl:value-of select="$LastRevisionAct_overpmt"/></xsl:when>
              <xsl:otherwise><xsl:value-of select="$LastRevisionAct_debt"/></xsl:otherwise>
            </xsl:choose>
            <xsl:text> </xsl:text>
            <xsl:call-template name="formatdate">
              <xsl:with-param name="datestr" select="@dateRevisionAt" />
            </xsl:call-template>
            <xsl:text>&#160;</xsl:text><xsl:value-of select="$year"/>
          </b>
        </xsl:when>
      </xsl:choose>
      <xsl:text>:</xsl:text>
    </td>
    <td class="number nowrap">
      <b>
        <xsl:value-of select="@sum"/>
      </b>
    </td>
  </tr>
  </xsl:template>

  <xsl:template match="LastRevisionAct/Reading">
    <xsl:text>, </xsl:text><xsl:value-of select="$LastRevisionAct_reading"/><xsl:text>: </xsl:text>
    <b>
      <xsl:apply-templates select="Scale" />
    </b>
  </xsl:template>


  <!--
    пропускаем узлы
  -->
  <xsl:template match="CommonCardYears/Year/Month//*[(count(../Service|../Typeuse|../Top|../Period|../Scale) = 1) and ((name(.) = 'Service') or (name(.) = 'Typeuse') or (name(.) = 'Period') or (name(.) = 'Top'))]">
  <xsl:param name="level">0</xsl:param>
  <xsl:param name="parent_class"/>
  <xsl:variable name="node_class"><xsl:value-of select="$parent_class"/></xsl:variable>

  <xsl:apply-templates select="." mode="external_info_container">
    <xsl:with-param name="level"><xsl:value-of select="$level"/></xsl:with-param>
    <xsl:with-param name="node_class"><xsl:value-of select="$node_class"/></xsl:with-param>
  </xsl:apply-templates>

  <xsl:apply-templates select="./*">
    <xsl:with-param name="level"><xsl:value-of select="$level"/></xsl:with-param>
    <xsl:with-param name="parent_class"><xsl:value-of select="$node_class"/></xsl:with-param>
  </xsl:apply-templates>
  </xsl:template>


 <!--
    Дополнительная строка к текущей строке для вывода "внешней" информации,
    которая будет добавляться в дельфийском клиенте
  -->
  <xsl:template match="*" mode="external_info_container">
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="node_class" />
    <xsl:if test="./@soi">
      <tr>
        <xsl:call-template name="set_class_for_row">
          <xsl:with-param name="level" select="$level"/>
          <xsl:with-param name="node_class" select="$node_class"/>
          <xsl:with-param name="node_class_prefix">x</xsl:with-param>
          <!-- node_id отдельно укажем, чтоб не определило, как @spi -->
          <xsl:with-param name="node_id"><xsl:value-of select="./@soi" /></xsl:with-param>
        </xsl:call-template>
        <xsl:choose>
          <xsl:when test="$with_description = '1'"><xsl:apply-templates select="SolveInfo" mode="solve_info"></xsl:apply-templates></xsl:when>
          <xsl:otherwise><xsl:apply-templates select="." mode="place_for_external_info"/></xsl:otherwise>
        </xsl:choose>
      </tr>
    </xsl:if>
    <!-- si = SolveInfo -->
    <xsl:if test="./@si">
      <tr>
        <xsl:call-template name="set_class_for_row">
          <xsl:with-param name="level" select="$level"/>
          <xsl:with-param name="node_class" select="$node_class"/>
          <xsl:with-param name="node_class_prefix">x</xsl:with-param>
        </xsl:call-template>
        <xsl:choose>
          <xsl:when test="$with_description = '1'"><xsl:apply-templates select="SolveInfo" mode="solve_info"></xsl:apply-templates></xsl:when>
          <xsl:otherwise><xsl:apply-templates select="." mode="place_for_external_info"/></xsl:otherwise>
        </xsl:choose>
      </tr>
    </xsl:if>
    <!-- spi = SolvePrivInfo -->
    <xsl:if test="./@spi">
      <tr>
        <xsl:call-template name="set_class_for_row">
          <xsl:with-param name="level" select="$level"/>
          <xsl:with-param name="node_class" select="$node_class"/>
          <xsl:with-param name="node_class_prefix">x</xsl:with-param>
        </xsl:call-template>
        <xsl:choose>
          <xsl:when test="$with_description = '1'"><xsl:apply-templates select="SolvePrivInfo" mode="solve_info"></xsl:apply-templates></xsl:when>
          <xsl:otherwise><xsl:apply-templates select="." mode="place_for_external_info"/></xsl:otherwise>
        </xsl:choose>
      </tr>
    </xsl:if>
    <!-- sri = SolveReduceInfo -->
    <xsl:if test="(./@sri)">
      <tr>
        <xsl:call-template name="set_class_for_row">
          <xsl:with-param name="level" select="$level"/>
          <xsl:with-param name="node_class" select="$node_class"/>
          <xsl:with-param name="node_class_prefix">x</xsl:with-param>
          <!-- node_id отдельно укажем, чтоб не определило, как @spi -->
          <xsl:with-param name="node_id"><xsl:value-of select="./@sri" /></xsl:with-param>
        </xsl:call-template>
        <xsl:choose>
          <xsl:when test="$with_description = '1'"><xsl:apply-templates select="SolveReduceInfo" mode="solve_info"></xsl:apply-templates></xsl:when>
          <xsl:otherwise><xsl:apply-templates select="." mode="place_for_external_info"/></xsl:otherwise>
        </xsl:choose>
      </tr>
    </xsl:if>
  </xsl:template>


  <!-- Место для вывода внешней информации -->
  <xsl:template match="*" mode="place_for_external_info">
    <td>
      <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count"/></xsl:attribute>
    </td>
  </xsl:template>
  <!-- этот будем с отступом -->
  <xsl:template match="Service" mode="place_for_external_info">
    <td colspan="2"></td>
    <td>
      <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count - 2"/></xsl:attribute>
    </td>
  </xsl:template>


  <!--
    Расшифровка льгот
  -->
  <xsl:template match="CommonCardYears//SolvePrivInfo" />
  <xsl:template match="CommonCardYears//SolvePrivInfo" mode="solve_info">
      <td>
        <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count"/></xsl:attribute>
          <h3><xsl:value-of select="@Head"/></h3>
          <ul>
            <xsl:apply-templates mode="solve_info"/>
          </ul>
      </td>
  </xsl:template>


  <!--
    Расшифровка начислений
  -->
  <xsl:template match="CommonCardYears//SolveInfo" />
  <xsl:template match="CommonCardYears//SolveInfo" mode="solve_info">
    <td>
      <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count"/></xsl:attribute>
      <xsl:apply-templates mode="solve_info" />
    </td>
  </xsl:template>


  <!--
    Расшифровка
  -->
  <xsl:template match="CommonCardYears//SolveReduceInfo" />
  <xsl:template match="CommonCardYears//SolveReduceInfo" mode="solve_info">
    <td>
      <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count"/></xsl:attribute>
      <xsl:apply-templates mode="solve_info" />
    </td>
  </xsl:template>


  <xsl:variable name="Period_from">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Період з</xsl:when>
          <xsl:otherwise>Период с</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <!-- Оформление расшфировки (mode="solve_info") -->
  <xsl:template match="Period"  mode="solve_info">
    <li>
      <b>
        <xsl:value-of select="$Period_from"/><xsl:text> </xsl:text>
        <xsl:value-of select="@begin"/>
        <xsl:text> </xsl:text><xsl:value-of select="$name_to"/><xsl:text> </xsl:text>
        <xsl:value-of select="@end"/>
      </b>
      <ol>
        <xsl:apply-templates mode="solve_info"/>
      </ol>
    </li>
  </xsl:template>

  <xsl:template match="Privilege"  mode="solve_info">
    <li>
      <p><b>
        <xsl:value-of select="@name"/>
        <xsl:text> </xsl:text>
        <xsl:value-of select="@percent"/>
        <xsl:text>%, </xsl:text>
        <xsl:value-of select="@privman"/>
        <xsl:text>, </xsl:text>
        <xsl:value-of select="@count"/>
        <xsl:text> </xsl:text><xsl:value-of select="$name_people"/><xsl:text>.</xsl:text>
      </b></p>
      <p><xsl:apply-templates mode="solve_info"/></p>
    </li>
  </xsl:template>

  <xsl:template match="Head" mode="solve_info">
    <b>
      <xsl:value-of select="."/>
    </b>
    <br/>
  </xsl:template>

  <xsl:template match="Text" mode="solve_info">
    <xsl:value-of select="."/>
    <br/>
  </xsl:template>

    <xsl:variable name="name_days">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Днів</xsl:when>
            <xsl:otherwise>Дней</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_debt">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Заборгованість</xsl:when>
            <xsl:otherwise>Задолженность</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_penalty">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Пеня</xsl:when>
            <xsl:otherwise>Пеня</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_month">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Місяць</xsl:when>
            <xsl:otherwise>Месяц</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_debt_sum">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Сума боргу</xsl:when>
            <xsl:otherwise>Сумма долга</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_pay_term">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Термін сплати</xsl:when>
            <xsl:otherwise>Срок оплаты</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_pay">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">
                <xsl:text>Cплата</xsl:text>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>Оплата</xsl:text>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_summa">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">
                <xsl:text>Сума</xsl:text>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>Сумма</xsl:text>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_date">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">
                <xsl:text>Дата</xsl:text>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text>Дата</xsl:text>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_pay_date">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Дата сплати</xsl:when>
            <xsl:otherwise>Дата оплаты</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_penalty_prc">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">% пені</xsl:when>
            <xsl:otherwise>% пени</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_penalty_sum">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Сума пені</xsl:when>
            <xsl:otherwise>Сумма пени</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_penalty_days">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Дні нарахування пені</xsl:when>
            <xsl:otherwise>Дни начисления пени</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_period_expired">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Період прострочення</xsl:when>
            <xsl:otherwise>Период просрочки</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:variable name="name_formula">
        <xsl:choose>
            <xsl:when test="$lang = 'uk'">Формула</xsl:when>
            <xsl:otherwise>Формула</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>

    <xsl:template match="FineService">
        <table style="text-align:center;">
            <thead>
                <tr>
                    <th colspan="2" style="font-weight:bold;"><xsl:value-of select="$name_debt"/></th>
                    <th colspan="2" style="font-weight:bold;"><xsl:value-of select="$name_pay"/></th>
                    <th colspan="3" style="font-weight:bold;"><xsl:value-of select="$name_period_expired"/></th>
                    <th colspan="3" style="font-weight:bold;"><xsl:value-of select="$name_penalty"/></th>
                </tr>
                <tr>
                    <th><xsl:value-of select="$name_month"/></th>
                    <th><xsl:value-of select="$name_summa"/></th>
<!--                    <th><xsl:value-of select="$name_pay_term"/></th>-->
                    <th><xsl:value-of select="$name_date"/></th>
                    <th><xsl:value-of select="$name_summa"/></th>
                    <th><xsl:value-of select="$name_from"/></th>
                    <th><xsl:value-of select="$name_to"/></th>
                    <th><xsl:value-of select="$name_days"/></th>
                    <th><xsl:value-of select="$name_penalty_prc"/></th>
                    <th><xsl:value-of select="$name_formula"/></th>
                    <th><xsl:value-of select="$name_summa"/></th>
                </tr>
            </thead>
            <tbody>
                <xsl:apply-templates select="Debt" />
            </tbody>
        </table>
    </xsl:template>

    <xsl:template match="FineService/Debt" >
        <xsl:variable name="rowspan" select="count(Item)" />
        <tr>
            <td style="text-align:center;">
                <xsl:attribute name="rowspan"><xsl:value-of select="$rowspan"/></xsl:attribute>
                <xsl:value-of select="@debtdatefee"/>
            </td>
            <td style="text-align:right;">
                <xsl:attribute name="rowspan"><xsl:value-of select="$rowspan"/></xsl:attribute>
                <xsl:value-of select="@debtsum"/>
            </td>
            <td style="text-align:center;">
                <xsl:attribute name="rowspan"><xsl:value-of select="$rowspan"/></xsl:attribute>
                <xsl:choose>
                    <xsl:when test="@debtdatepay = ''"><xsl:text>-</xsl:text></xsl:when>
                    <xsl:otherwise><xsl:value-of select="@debtdatepay"/></xsl:otherwise>
                </xsl:choose>
            </td>
            <xsl:choose>
                <xsl:when test="@debtdatepay = ''">
                    <td style="text-align:center;">
                    <xsl:attribute name="rowspan"><xsl:value-of select="$rowspan"/></xsl:attribute>
                        <xsl:text>-</xsl:text>
                    </td>
                </xsl:when>
                <xsl:otherwise>
                    <td style="text-align:right;">
                    <xsl:attribute name="rowspan"><xsl:value-of select="$rowspan"/></xsl:attribute>
                        <xsl:value-of select="@paysum"/>
                    </td>
                </xsl:otherwise>
            </xsl:choose>
            <xsl:apply-templates select="Item[1]" mode="first_row" />
        </tr>
        <xsl:apply-templates select="Item[position() &gt; 1]" mode="other_rows" />
    </xsl:template>

    <xsl:template match="Debt/Item" mode="first_row" >
        <td style="text-align:center;"> <xsl:value-of select="@periodbegin"/>   </td>
        <td style="text-align:center;"> <xsl:value-of select="@periodend"/>     </td>
        <td style="text-align:center;"> <xsl:value-of select="@periodsize"/>    </td>
        <td style="text-align:left; padding-left: 3mm;"> <xsl:value-of select="@fineratedesc"/> </td>
        <td style="text-align:left; padding-left: 3mm;"> <xsl:value-of select="@formula"/>      </td>
        <td style="text-align:right;">
            <xsl:value-of select="@finesum"/>
        </td>
    </xsl:template>

    <xsl:template match="Debt/Item" mode="other_rows" >
      <tr>
          <xsl:apply-templates select="." mode="first_row" />
      </tr>
    </xsl:template>

<!--
  Определение класса для строки таблицы
-->
  <xsl:template name="set_class_for_row">
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="node_class_prefix">p</xsl:param>
    <xsl:param name="node_id">
      <xsl:choose>
        <xsl:when test="@spi"><xsl:value-of select="@spi"/></xsl:when>
        <xsl:when test="@soi"><xsl:value-of select="@soi"/></xsl:when>
        <xsl:when test="@sri"><xsl:value-of select="@sri"/></xsl:when>
        <xsl:otherwise><xsl:value-of select="@si"/></xsl:otherwise>
      </xsl:choose>
    </xsl:param>
    <xsl:param name="node_class" />
    <!--  class="Year level_1"  -->
    <xsl:attribute name="class">
      <xsl:value-of select="name(.)"/>
      <xsl:text> level_</xsl:text>
      <xsl:value-of select="$level"/>
      <xsl:text> </xsl:text>
      <xsl:value-of select="$node_class_prefix"/>
      <xsl:value-of select="$node_class"/>
      <xsl:if test="(position() + $level) mod 2 = 0">
      <xsl:text> altrow</xsl:text>
      </xsl:if>
      <xsl:if test="(@spi or @si or @soi or @sri) and $node_class_prefix='x' "> Info</xsl:if>
      <!-- FIXME -->
    </xsl:attribute>
    <!-- ID -->
    <xsl:if test="$node_id and $node_class_prefix='x' ">
      <xsl:attribute name="id">
        <xsl:value-of select="$node_id"/>
      </xsl:attribute>
    </xsl:if>
  </xsl:template>

<!--
  Содержимое строки в таблице
-->
  <xsl:template match="*" mode="row_content">
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="node_class" />
    <td class="period"><xsl:apply-templates select="." mode="td_month_content"/></td>
    <td class="name string">
      <xsl:apply-templates select="." mode="td_service_content">
        <xsl:with-param name="level" select="$level"/>
        <xsl:with-param name="node_class" select="$node_class"/>
      </xsl:apply-templates>
    </td>

    <xsl:apply-templates select="." mode="row_basic_content"/>
  </xsl:template>

  <!-- Основное содержимое (без колонок "Месяц" и "услуга") -->
  <xsl:template match="*" mode="row_basic_content">
    <xsl:if test="$columns_for_readings &gt; 0">
      <xsl:apply-templates select="." mode="td_readings_content"/>
    </xsl:if>
    <td class="number nowrap"><xsl:apply-templates select="." mode="td_fee_value_content"/></td>
    <xsl:if test="$columns_for_privel &gt; 0">
      <td class="number nowrap">
        <xsl:apply-templates select="." mode="td_fee_priv_value_content"/>
      </td>
    </xsl:if>
    <xsl:if test="$for_russia='1'">
      <td class="number nowrap">
        <xsl:apply-templates select="." mode="td_odn_content"/>
      </td>
    </xsl:if>
    <td class="tariff nowrap"><xsl:apply-templates select="." mode="td_tariff_content"/> </td>
    <xsl:if test="$fee_wo_compens = 'true'">
        <td class="number nowrap"> <xsl:apply-templates select="." mode="td_fee_wo_compens_content"/> </td>
    </xsl:if>
    <td class="number nowrap"><xsl:apply-templates select="." mode="td_fee_sum_content"/> </td>
    <td class="number nowrap"><xsl:apply-templates select="." mode="td_pay_sum_content"/> </td>
    <xsl:if test="$columns_for_privel &gt; 0">
      <td class="number nowrap"><xsl:apply-templates select="." mode="td_subs_sum_content"/></td>
    </xsl:if>
    <td class="number nowrap"><xsl:apply-templates select="." mode="td_saldo_sum_content"/> </td>
  </xsl:template>


<!-- Содержимое ячеек -->
  <xsl:template match="*" mode="td_month_content">
    <xsl:apply-templates select="@number" />
  </xsl:template>

  <xsl:template match="*" mode="td_service_content">
    <xsl:param name="node_class" />
    <xsl:param name="level">0</xsl:param>

    <xsl:apply-templates select="." mode="td_service_content_image" >
      <xsl:with-param name="node_class" select="$node_class" />
      <xsl:with-param name="level" select="$level" />
    </xsl:apply-templates>

    <xsl:apply-templates select="." mode="td_service_content_text" >
      <xsl:with-param name="node_class" select="$node_class" />
      <xsl:with-param name="level" select="$level" />
    </xsl:apply-templates>
  </xsl:template>


  <xsl:template match="*" mode="td_service_content_text">
    <xsl:param name="node_class" />
    <xsl:param name="level">0</xsl:param>

    <xsl:apply-templates select="@name" />
    <xsl:if test="count(Service|Typeuse|Top|Period|Scale) = 1">
      <xsl:text> </xsl:text>
      <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_service_content_text" >
        <xsl:with-param name="node_class" select="$node_class" />
        <xsl:with-param name="level" select="$level" />
      </xsl:apply-templates>
    </xsl:if>
  </xsl:template>


  <xsl:template match="*" mode="td_service_content_image">
    <xsl:param name="node_class" />
    <xsl:param name="level">0</xsl:param>

    <xsl:choose>
      <!--
        Если дочерний узел из "активных" один - кнопки раскрытия не выводим, опускаемся ниже, а его инфомрацию поднимаем уровень выше.
        Исключение составляет только один узел периода Period, у которого может быть несколько зон (Scale).
      -->
      <xsl:when test="count(Service|Typeuse|Top|Period|Scale)=1 and (name(.)!='Top' or (count(Period)=1 and count(Period/Scale)=1))">
        <!-- <xsl:comment> * IMG WHEN <xsl:value-of select="name(.)" /></xsl:comment> -->
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_service_content_image" >
          <xsl:with-param name="node_class" select="$node_class" />
          <xsl:with-param name="level" select="$level" />
        </xsl:apply-templates>
      </xsl:when>
      <xsl:otherwise>
        <!-- <xsl:comment> * IMG OTHER <xsl:value-of select="name(.)" /></xsl:comment> -->
        <xsl:if test="./*">
          <!-- <img src="cc1.gif" alt="[+]" class="toggle_rows lvl_{$level}" id="{$node_class}"/> -->
          <!-- <i class="toggle_rows lvl_{$level} cc_closed" id="{$node_class}">+</i> -->
          <xsl:call-template name="btn">
            <xsl:with-param name="src" select="'cc1.gif'"/>
            <xsl:with-param name="class">toggle_rows lvl_<xsl:value-of select="$level"/> cc_closed</xsl:with-param>
            <xsl:with-param name="id" select="$node_class"/>
            <xsl:with-param name="content" select="'+'"/>
          </xsl:call-template>
        </xsl:if>
        <xsl:if test="./@si">
          <!-- <img src="cc3.gif" alt="[*]" class="show-or-hide" id="x{@si}"/> -->
          <!-- <i  class="show-or-hide cc_hidden" id="x{@si}">?</i> -->
          <xsl:call-template name="btn">
            <xsl:with-param name="src" select="'cc3.gif'"/>
            <xsl:with-param name="class">show-or-hide cc_hidden</xsl:with-param>
            <xsl:with-param name="id" select="concat('x', @si)"/>
            <xsl:with-param name="content" select="'?'"/>
          </xsl:call-template>
        </xsl:if>
        <xsl:if test="not(./@si) and not (./*)">
          <span class="no_img"></span>
        </xsl:if>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <!-- Год - кнопка сворачивания дочерних строк должна быть всегда -->
  <xsl:template match="Year" mode="td_service_content_image">
    <xsl:param name="node_class" />
    <xsl:param name="level">0</xsl:param>

    <!-- <img src="cc1.gif" alt="[+]" class="toggle_rows lvl_{$level}" id="{$node_class}"/> -->
    <!-- <i class="toggle_rows lvl_{$level} cc_closed" id="{$node_class}">+</i> -->
    <xsl:call-template name="btn">
      <xsl:with-param name="src" select="'cc1.gif'"/>
      <xsl:with-param name="class">toggle_rows lvl_<xsl:value-of select="$level"/> cc_closed</xsl:with-param>
      <xsl:with-param name="id" select="$node_class"/>
      <xsl:with-param name="content" select="'+'"/>
    </xsl:call-template>

    <xsl:if test="./@si">
      <!-- <img src="cc3.gif" alt="[*]" class="show-or-hide" id="x{@si}"/> -->
      <!-- <i class="show-or-hide cc_hidden" id="x{@si}">?</i> -->
      <xsl:call-template name="btn">
        <xsl:with-param name="src" select="'cc3.gif'"/>
        <xsl:with-param name="class">show-or-hide cc_hidden</xsl:with-param>
        <xsl:with-param name="id" select="concat('x', @si)"/>
        <xsl:with-param name="content" select="'?'"/>
      </xsl:call-template>
    </xsl:if>
  </xsl:template>


  <xsl:template match="*" mode="td_fee_value_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@feeValue)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_fee_value_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="@feeValue"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template match="*" mode="td_fee_priv_value_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@privValue)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_fee_priv_value_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:if test="./@spi">
          <!-- <img src="cc3.gif" alt="[*]" class="show-or-hide" id="x{@spi}"/> -->
          <!-- <i class="show-or-hide cc_hidden" id="x{@spi}">?</i> -->
          <xsl:call-template name="btn">
            <xsl:with-param name="src" select="'cc3.gif'"/>
            <xsl:with-param name="class">show-or-hide cc_hidden</xsl:with-param>
            <xsl:with-param name="id" select="concat('x', @spi)"/>
            <xsl:with-param name="content" select="'?'"/>
          </xsl:call-template>
        </xsl:if>
        <xsl:if test="not(./@spi) and not (./*)">
          <span class="no_img"></span>
        </xsl:if>
        <xsl:apply-templates select="@privValue"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template match="*" mode="td_odn_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@odn)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_odn_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:if test="./@soi">
          <!-- <img src="cc3.gif" alt="[*]" class="show-or-hide" id="x{@soi}"/> -->
          <!-- <i class="show-or-hide cc_hidden" id="x{@soi}">?</i> -->
          <xsl:call-template name="btn">
            <xsl:with-param name="src" select="'cc3.gif'"/>
            <xsl:with-param name="class">show-or-hide cc_hidden</xsl:with-param>
            <xsl:with-param name="id" select="concat('x', @soi)"/>
            <xsl:with-param name="content" select="'?'"/>
          </xsl:call-template>
        </xsl:if>
        <xsl:if test="not(./@soi) and not (./*)">
          <span class="no_img"></span>
        </xsl:if>
        <xsl:apply-templates select="./@odn"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="*" mode="td_fee_wo_compens_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@feeSumWoCompens)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_fee_wo_compens_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="@feeSumWoCompens"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:variable name="month_sum_no_comp_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Сума нарахувань без компенсації за місяць</xsl:when>
          <xsl:otherwise>Сумма начислений без компенсации за месяц</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="Month" mode="td_fee_wo_compens_content">
    <xsl:variable name="fee_wo_sum" select="sum(.//*/@feeSumWoCompens)"/>
    <span>
      <xsl:attribute name="title">
        <xsl:value-of select="$month_sum_no_comp_name"/>
      </xsl:attribute>
      <xsl:value-of select="format-number($fee_wo_sum, $currency_format, 'format_settings')" />
    </span>
  </xsl:template>


  <xsl:template match="*" mode="td_tariff_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top) = 1) and not (Tariffs)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_tariff_content_summary" />
      </xsl:when>
      <xsl:when test="(count(Period|Scale) = 1) and not (Tariffs)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_tariff_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="Tariffs"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="*" mode="td_tariff_content_summary">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top) = 1) and not (Tariffs)">
        <xsl:apply-templates select="Service|Typeuse|Top" mode="td_tariff_content_summary" />
      </xsl:when>
      <xsl:when test="Period">
        <xsl:apply-templates select="Period[1]/Scale" mode="tariff_summary"/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_tariff_content" />
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="*" mode="td_fee_sum_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@feeSum)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_fee_sum_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:if test="./@sri">
          <!-- <img src="cc3.gif" alt="[*]" class="show-or-hide" id="x{@sri}"/> -->
          <!-- <i class="show-or-hide cc_hidden" id="x{@sri}">?</i> -->
          <xsl:call-template name="btn">
            <xsl:with-param name="src" select="'cc3.gif'"/>
            <xsl:with-param name="class">show-or-hide cc_hidden</xsl:with-param>
            <xsl:with-param name="id" select="concat('x', @sri)"/>
            <xsl:with-param name="content" select="'?'"/>
          </xsl:call-template>
        </xsl:if>
        <xsl:if test="not(./@sri) and not (./*)">
          <span class="no_img"></span>
        </xsl:if>
        <xsl:apply-templates select="@feeSum"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:variable name="month_sum_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Сума нарахувань місяць</xsl:when>
          <xsl:otherwise>Сумма начислений за месяц</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="Month" mode="td_fee_sum_content">
    <xsl:variable name="fee_sum" select="sum(.//*/@feeSum)"/>
    <span>
      <xsl:attribute name="title">
        <xsl:value-of select="$month_sum_name"/>
      </xsl:attribute>
      <xsl:value-of select="format-number($fee_sum, $currency_format, 'format_settings')" />
    </span>
  </xsl:template>

  <xsl:variable name="recalc_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Перерахунок</xsl:when>
          <xsl:otherwise>Перерасчет</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <!-- в картоку 5ки расширяем значения в колонке "Начислено, руб" для строки уровня услуги (узел Service).
    Если в нем есть атрибут reduceSum, то значение колонки принимает вид: origSum - reduceSum = feeSum
    где origSum - это сумма feeSum и reduceSum
    текст "origSum - reduceSum =" наверное лучше сделать шрифтом помельче, по аналогии как в колонке тарифа -->
  <xsl:template match="@feeSum">
     <xsl:choose>
      <xsl:when test="../@reduceSum">
          <span class="hint">
              <xsl:attribute name="title">
                  <xsl:value-of select="$recalc_name"/>
              </xsl:attribute>
              <xsl:variable name="orig_sum" select="../@feeSum + ../@reduceSum" />
              <xsl:value-of select="format-number($orig_sum, $currency_format, 'format_settings')" />
              <xsl:text>&#160;-&#160;</xsl:text>
              <xsl:value-of select="../@reduceSum" />
              <xsl:text>&#160;=&#160;</xsl:text>
          </span>
          <xsl:value-of select="." />
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="." />
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="*" mode="td_pay_sum_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@paySum)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_pay_sum_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="@paySum"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template match="*" mode="td_subs_sum_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@subsSum)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_subs_sum_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="@subsSum"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="*" mode="td_saldo_sum_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top|Period|Scale) = 1) and not (@saldoSum)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_saldo_sum_content" />
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="@saldoSum"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:variable name="total_for_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Разом за</xsl:when>
          <xsl:otherwise>Всего за</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="year_full">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">рік</xsl:when>
          <xsl:otherwise>год</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="Year" mode="td_service_content_text" >
    <xsl:value-of select="$total_for_name"/><xsl:text> </xsl:text>
    <!--xsl:value-of select="@number"/-->
    <xsl:text> </xsl:text><xsl:value-of select="$year_full"/>
  </xsl:template>

<!--  Если период один - его название "подтягивать вверх" (вообще отображать) не будем  -->
  <xsl:template match="Top/Period[count(../Period) = 1]" mode="td_service_content_text" />

  <xsl:template match="Scale/@name" >
    <xsl:variable name="v" select="." />
    <xsl:if test="$v != ''">
      <b>
        <xsl:text>&#171;</xsl:text>
        <xsl:value-of select="$v" />
        <xsl:text>&#187;</xsl:text>
      </b>
    </xsl:if>
  </xsl:template>


<!--
  Период - месяц, год.
  Добавляем к номеру месяца год и "0", если меньше 10го
-->
  <xsl:template match="Month/@number">
    <xsl:variable name="month_number" select="." />
    <xsl:variable name="year_number" select="../../@number" />
    <xsl:if test="$month_number &lt; 10">
      <xsl:text>0</xsl:text>
    </xsl:if>
    <xsl:value-of select="$month_number"/>
    <xsl:text>.</xsl:text>
    <xsl:value-of select="$year_number" />
  </xsl:template>


<!--
  Строка месяца - список услуг в поле "Услуги"
-->
  <xsl:template match="Month/@name">
    <xsl:apply-templates select="../Service" mode="just_names" >
      <xsl:with-param name="items_count" select="count(../Service)" />
    </xsl:apply-templates>
  </xsl:template>

  <!--
    Название услуги для строки месяца
  -->
  <xsl:template match="Service" mode="just_names">
    <xsl:param name="items_count" select="1" />
    <xsl:value-of select="@name"/>
    <xsl:if test="position() &lt; $items_count">
      <xsl:text>, </xsl:text>
    </xsl:if>
  </xsl:template>


<!--
  Оплаты - добавляем количество оплат
-->
  <xsl:variable name="subs_num_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Кількість субсидій</xsl:when>
          <xsl:otherwise>Количество субсидий</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="@subsSum">
    <xsl:if test="number(../@subsCnt) &gt; 1">
      <span class="hint">
        <xsl:attribute name="title">
            <xsl:value-of select="$subs_num_name"/>
        </xsl:attribute>
        <xsl:text>(</xsl:text>
        <xsl:value-of select="../@subsCnt" />
        <xsl:text>) </xsl:text>
      </span>
    </xsl:if>
    <span class="nowrap"><xsl:value-of select="." /></span>
  </xsl:template>


<!--
  Субсидии - добавляем количество оплат
-->
  <xsl:variable name="pays_num_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Кількість платежів</xsl:when>
          <xsl:otherwise>Количество платежей</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="@paySum">
    <xsl:if test="number(../@payCnt) &gt; 1">
      <span class="hint">
        <xsl:attribute name="title">
            <xsl:value-of select="$pays_num_name"/>
        </xsl:attribute>
        <xsl:text>(</xsl:text>
        <xsl:value-of select="../@payCnt" />
        <xsl:text>) </xsl:text>
      </span>
    </xsl:if>
    <span class="nowrap"><xsl:value-of select="." /></span>
  </xsl:template>


  <!--
    Шаблон для обращения к узлам ReadingBeg | ReadingEnd
  -->
  <xsl:template match="*" mode="td_readings_content">
    <xsl:choose>
      <xsl:when test="(count(Service|Typeuse|Top) = 1) and not (ReadingBeg|ReadingEnd)">
        <xsl:apply-templates select="Service|Typeuse|Top" mode="td_readings_content_summary" />
      </xsl:when>
      <xsl:when test="(count(Period|Scale) = 1) and not (ReadingBeg|ReadingEnd)">
        <xsl:apply-templates select="Service|Typeuse|Top|Period|Scale" mode="td_readings_content" />
      </xsl:when>
      <xsl:otherwise>
        <!-- ReadingBeg -->
        <xsl:choose>
          <xsl:when test="ReadingBeg">
            <xsl:apply-templates select="ReadingBeg" /></xsl:when>
          <xsl:otherwise>
            <td>&#160;</td></xsl:otherwise>
        </xsl:choose>
        <!-- ReadingEnd -->
        <xsl:choose>
          <xsl:when test="ReadingEnd">
            <xsl:apply-templates select="ReadingEnd" /></xsl:when>
          <xsl:otherwise>
            <td>&#160;</td></xsl:otherwise>
        </xsl:choose>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>


  <xsl:template match="*" mode="td_readings_content_summary">
    <xsl:choose>
      <xsl:when test="(count(Typeuse[count(.//ReadingBeg)&gt;0]) = 1) and not (Tariffs)">
        <xsl:apply-templates select="Service|Typeuse[count(.//ReadingBeg)&gt;0]|Top" mode="td_readings_content_summary" />
      </xsl:when>
      <xsl:when test="(count(Service|Typeuse|Top) = 1) and not (Tariffs)">
        <xsl:apply-templates select="Service|Typeuse|Top" mode="td_readings_content_summary" />
      </xsl:when>
      <xsl:when test="Period">
        <xsl:apply-templates select="." mode="period_readings_summary" />
      </xsl:when>
      <xsl:when test="Service|Typeuse|Top|Period|Scale">
        <xsl:apply-templates select="." mode="td_readings_content" />
      </xsl:when>
      <xsl:otherwise>
        <td>&#160;</td><td>&#160;</td>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <!--
    ReadingBeg | ReadingEnd
  -->
  <xsl:variable name="count_val_day_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">День зняття показань</xsl:when>
          <xsl:otherwise>День снятия показаний</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="perekrut_num_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">кількість 'перекрутів' лічильника</xsl:when>
          <xsl:otherwise>количество 'перекрутов' счетчика</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="CommonCardYears//ReadingBeg|CommonCardYears//ReadingEnd">
    <td class="number readings cstatus_{@type}">
      <div>
        <xsl:apply-templates select="." mode="readings_status" />
        <xsl:if test="number(@day) &gt; 0">
          <span class="hint">
            <xsl:attribute name="title">
              <xsl:value-of select="$count_val_day_name"/>
            </xsl:attribute>
            <xsl:text>(</xsl:text>
            <xsl:value-of select="@day" />
            <xsl:text>)&#160;</xsl:text>
          </span>
        </xsl:if>
        <xsl:if test="($template_mode = 'client') and (number(@perekrut) &gt; 0)">
          <span class="perekrut_count">
            <xsl:attribute name="title">
              <xsl:value-of select="$perekrut_num_name"/>
            </xsl:attribute>
            <xsl:value-of select="@perekrut"/>
            <xsl:text>/</xsl:text>
          </span>
        </xsl:if>
        <xsl:value-of select="@value" />

        <xsl:if test="count(../../../Period)=1">
          <xsl:if test="name()='ReadingBeg'">
            <xsl:if test="count(../../Scale/ReadingBeg[@type='1']|../../Scale/ReadingEnd[@type='1']) &gt; 0">
              <xsl:text>&#160;</xsl:text>
              <span class="r contr-r">*</span>
            </xsl:if>
          </xsl:if>

          <xsl:if test="name()='ReadingEnd'">
            <xsl:if test="count(../../Scale/ReadingBeg[@type='2']|../../Scale/ReadingEnd[@type='2']|../../Scale/ReadingBeg[@type='3']|../../Scale/ReadingEnd[@type='3']) &gt; 0">
              <span class="r abon-r">*</span>
            </xsl:if>
          </xsl:if>
        </xsl:if>
      </div>
    </td>
  </xsl:template>


  <xsl:template match="*" mode="period_readings_summary">
    <td>
      <xsl:attribute name="class">
        <xsl:text>number readings cstatus_</xsl:text>
        <xsl:value-of select="Period[last()]/Scale/ReadingBeg/@type"/>
      </xsl:attribute>

      <div>
        <xsl:apply-templates select="Period[last()]/Scale/ReadingBeg"  mode="readings_summary"/>
        <xsl:if test="count(Period/Scale/ReadingBeg[@type='1']|Period/Scale/ReadingEnd[@type='1']) &gt; 0">
          <xsl:text> </xsl:text>
          <span class="r contr-r">*</span>
        </xsl:if>
      </div>
    </td>
    <td>
      <xsl:attribute name="class">
        <xsl:text>number readings cstatus_</xsl:text>
        <xsl:value-of select="Period[1]/Scale/ReadingEnd/@type"/>
      </xsl:attribute>
      <div>
        <xsl:apply-templates select="Period[1]/Scale/ReadingEnd" mode="readings_summary"/>
        <xsl:if test="count(Period/Scale/ReadingBeg[@type='2']|Period/Scale/ReadingEnd[@type='2']|Period/Scale/ReadingBeg[@type='3']|Period/Scale/ReadingEnd[@type='3']) &gt; 0">
          <xsl:text> </xsl:text>
          <span class="r abon-r">*</span>
        </xsl:if>
      </div>
    </td>
  </xsl:template>


  <!--  -->
  <xsl:template match="CommonCardYears//ReadingBeg|CommonCardYears//ReadingEnd" mode="readings_summary">
    <xsl:if test="position() &gt; 1">
      <br/>
    </xsl:if>
    <xsl:apply-templates select="." mode="readings_status" />
    <xsl:if test="number(@day) &gt; 0">
      <span class="hint">
        <xsl:attribute name="title">
          <xsl:value-of select="$count_val_day_name"/>
        </xsl:attribute>
        <xsl:text>(</xsl:text>
        <xsl:value-of select="@day" />
        <xsl:text>)&#160;</xsl:text>
      </span>
    </xsl:if>
    <xsl:if test="($template_mode = 'client') and (number(@perekrut) &gt; 0)">
      <span class="perekrut_count">
        <xsl:attribute name="title">
          <xsl:value-of select="$perekrut_num_name"/>
        </xsl:attribute>
        <xsl:value-of select="@perekrut"/>
        <xsl:text>/</xsl:text>
      </span>
    </xsl:if>
    <xsl:value-of select="@value" />
  </xsl:template>

<!--
  К названию услуги добавим едину измерения, если есть такой аттрибут
-->
  <xsl:template match="Service/@name">
    <xsl:if test="count(../../Service) &gt; 1">
      <xsl:value-of select="."/>
    </xsl:if>
    <!--xsl:if test="../@unit">
      <xsl:text> (</xsl:text>
      <xsl:value-of select="../@unit"/>
      <xsl:text>)</xsl:text>
    </xsl:if-->
  </xsl:template>


<!--
  Название периода
-->
  <xsl:template match="Period/@name">
    <!-- <xsl:text>период с&#160;</xsl:text> -->
    <xsl:text>с&#160;</xsl:text>
    <xsl:value-of select="../@begin"/>
    <xsl:text>&#160;до&#160;</xsl:text>
    <xsl:value-of select="../@end"/>
  </xsl:template>

<!--
  Line
  Описание.
  По идее, будет выводиться внутри какой то ячейки
-->
  <xsl:template match="CommonCardYears//Line" mode="inline">
    <br/><span class="Line"><xsl:value-of select="@data"/></span>
  </xsl:template>


<!--
  Top
  у которых нет ни одного аттрибута
  (уровень и класс не наращиваем)
-->
  <xsl:template match="Top[count(@*) = 0]" >
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="parent_class"/>
    <xsl:variable name="node_class" select="$parent_class"/>
    <xsl:apply-templates >
      <xsl:with-param name="level"><xsl:value-of select="$level"/></xsl:with-param>
      <xsl:with-param name="parent_class"><xsl:value-of select="$node_class"/></xsl:with-param>
    </xsl:apply-templates>
  </xsl:template>


  <!-- Top не будем "подтягивать вверх" для колонки "Услуга" -->
  <xsl:template match="Top/@name" />
  <!-- А при обычном отображении - покажем наименование точки (Top) -->
  <xsl:template match="Top" mode="td_service_content">
    <xsl:param name="node_class" />
    <xsl:param name="level">0</xsl:param>

    <xsl:apply-templates select="." mode="td_service_content_image" >
      <xsl:with-param name="node_class" select="$node_class" />
      <xsl:with-param name="level" select="$level" />
    </xsl:apply-templates>

    <xsl:value-of select="@name" />
  </xsl:template>


<!--
  Period
-->
  <xsl:template match="CommonCardYears//Top/Period">
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="parent_class"/>
    <xsl:variable name="node_class" select="concat($parent_class, '_', position())"/>
    <tr>
      <xsl:call-template name="set_class_for_row">
        <xsl:with-param name="level" select="$level"/>
        <xsl:with-param name="node_class" select="$node_class"/>
      </xsl:call-template>
      <td class="period"></td>
      <td class="name string">
        <xsl:apply-templates select="." mode="td_service_content">
          <xsl:with-param name="level" select="$level"/>
          <xsl:with-param name="node_class" select="$node_class"/>
        </xsl:apply-templates>
      </td>

      <xsl:apply-templates select="Scale[1]" >
        <xsl:with-param name="level" select="$level + 1"/>
        <xsl:with-param name="parent_class" select="$node_class"/>
      </xsl:apply-templates>
    </tr>

    <xsl:apply-templates select="Scale[1]/SolveInfo" >
      <xsl:with-param name="level" select="$level + 1"/>
      <xsl:with-param name="parent_class" select="$node_class"/>
    </xsl:apply-templates>

    <xsl:apply-templates select="Scale[1]/SolveReduceInfo" >
      <xsl:with-param name="level" select="$level + 1"/>
      <xsl:with-param name="parent_class" select="$node_class"/>
    </xsl:apply-templates>

    <xsl:if test="Scale[1]/@si">
      <tr>
        <xsl:call-template name="set_class_for_row">
          <xsl:with-param name="level" select="$level"/>
          <xsl:with-param name="node_class" select="concat($node_class, ' Info')"/>
          <xsl:with-param name="node_class_prefix">x</xsl:with-param>
          <xsl:with-param name="node_id" select="Scale[1]/@si" />
        </xsl:call-template>
        <xsl:choose>
          <xsl:when test="$with_description = '1'"><xsl:apply-templates select="Scale[1]/SolvePrivInfo|Scale[1]/SolveInfo" mode="solve_info" /></xsl:when>
          <xsl:otherwise><xsl:apply-templates select="." mode="place_for_external_info"/></xsl:otherwise>
        </xsl:choose>
      </tr>
    </xsl:if>
    <xsl:apply-templates select="Scale[1]/SolveInfo" >
      <xsl:with-param name="level" select="$level + 1"/>
      <xsl:with-param name="parent_class" select="$node_class"/>
    </xsl:apply-templates>

    <xsl:apply-templates select="Scale[1]/SolveReduceInfo" >
      <xsl:with-param name="level" select="$level + 1"/>
      <xsl:with-param name="parent_class" select="$node_class"/>
    </xsl:apply-templates>

    <xsl:apply-templates select="Scale[position() != 1]" >
      <xsl:with-param name="level" select="$level "/>
      <xsl:with-param name="parent_class" select="$node_class"/>
      <!-- Класс наращивать не будем родительский -->
      <xsl:with-param name="freeze_parent_class" select= "'True'" />
    </xsl:apply-templates>
  </xsl:template>


  <xsl:template match="Period" mode="td_service_content">
    <xsl:param name="node_class" />
    <xsl:param name="level">0</xsl:param>

    <xsl:apply-templates select="." mode="td_service_content_image" >
      <xsl:with-param name="node_class" select="$node_class" />
      <xsl:with-param name="level" select="$level" />
    </xsl:apply-templates>

    <xsl:if test="count(../Period)&gt;1">
      <xsl:apply-templates select="@name" />
      <xsl:text> </xsl:text>
    </xsl:if>
    <xsl:apply-templates select="Scale[1]/@name" />
  </xsl:template>



  <xsl:template match="Period" mode="td_service_content_image">
    <xsl:param name="node_class" />
    <xsl:param name="level">0</xsl:param>

    <!-- <xsl:comment> Period IMG<xsl:value-of select="name(.)" /></xsl:comment> -->

    <xsl:if test="Scale[1]/@si">
      <!-- <img src="cc3.gif" alt="[*]" class="show-or-hide" id="x{Scale[1]/@si}"/> -->
      <!-- <i class="show-or-hide cc_hidden" id="x{Scale[1]/@si}">?</i> -->
      <xsl:call-template name="btn">
        <xsl:with-param name="src" select="'cc3.gif'"/>
        <xsl:with-param name="class">show-or-hide cc_hidden</xsl:with-param>
        <xsl:with-param name="id" select="concat('x', Scale[1]/@si)"/>
        <xsl:with-param name="content" select="'?'"/>
      </xsl:call-template>
    </xsl:if>
    <xsl:if test="not(Scale[1]/@si)">
      <span class="no_img"></span>
    </xsl:if>
  </xsl:template>

<!--
  Scale не первый
-->
  <!-- Дочерние не обрабатываем -->
  <xsl:template match="CommonCardYears//Scale" mode="apply_templates" />

  <xsl:template match="CommonCardYears//Scale" mode="row_content" >
    <td class="period">&#160;</td>
    <td class="name string">
      <xsl:if test="./@si">
        <!-- <img src="cc3.gif" alt="[*]" class="show-or-hide" id="x{@si}"/> -->
        <!-- <i class="show-or-hide cc_hidden" id="x{@si}"></i> -->
      <xsl:call-template name="btn">
        <xsl:with-param name="src" select="'cc3.gif'"/>
        <xsl:with-param name="class">show-or-hide cc_hidden</xsl:with-param>
        <xsl:with-param name="id" select="concat('x', @si)"/>
        <xsl:with-param name="content" select="'?'"/>
      </xsl:call-template>
      </xsl:if>
      <xsl:if test="not(./@si)">
        <span class="no_img"></span>
      </xsl:if>
      <xsl:apply-templates select="@name" />
    </td>
    <xsl:apply-templates select="." mode="row_basic_content"/>
  </xsl:template>


<!--
  Scale певый
-->
  <xsl:template match="CommonCardYears//Scale[1]">
    <xsl:apply-templates select="." mode="row_basic_content"/>
  </xsl:template>


<!--
  Tariffs
-->
  <xsl:template match="CommonCardYears//Tariffs">
    <xsl:apply-templates select="Item" >
      <xsl:with-param name="items_count" select="count(Item)"/>
    </xsl:apply-templates>
  </xsl:template>


<!--
  Tariffs/Item
  компенсация тарифа. необязательные поля compenspercent и tariforig.
  Если они есть, то значение тарифа надо выводить в виде tariforig - compenspercent% = tariff
-->
  <xsl:variable name="tarif_vol_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Обсяг споживання за вказаним тарифом</xsl:when>
          <xsl:otherwise>Объем потребления по указанному тарифу</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="tarif_comp_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Компенсація тарифу</xsl:when>
          <xsl:otherwise>Компенсация тарифа</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="CommonCardYears//Tariffs/Item">
    <xsl:param name="items_count" />
    <div>
      <xsl:if test="../@isStep = 'true'">
        <span class="hint">
          <xsl:attribute name="title">
            <xsl:value-of select="$tarif_vol_name"/>
          </xsl:attribute>
          <xsl:text>(</xsl:text>
          <xsl:value-of select="@feeValue"/>
          <xsl:text>)</xsl:text>
        </span>
        <xsl:text> </xsl:text>
      </xsl:if>
      <xsl:if test="@compenspercent">
          <span class="hint">
            <xsl:attribute name="title">
              <xsl:value-of select="$tarif_comp_name"/>
            </xsl:attribute>
            <xsl:value-of select="@tariforig"/>
            <xsl:text>&#160;*&#160;</xsl:text>
            <xsl:value-of select="@compenspercent"/>
            <xsl:text>%&#160;=&#160;</xsl:text>
          </span>
      </xsl:if>
      <xsl:value-of select="@tariff"/>
    </div>
  </xsl:template>


  <xsl:variable name="apply_from_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">який застосовувався з</xsl:when>
          <xsl:otherwise>который применялся c</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="for_zone_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">по зоні</xsl:when>
          <xsl:otherwise>по зоне</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="CommonCardYears//Scale" mode="tariff_summary">
    <xsl:if test="position()!=1"><br/></xsl:if>
    <div>
      <xsl:attribute name="title">
        <xsl:value-of select="$tarif_name"/><xsl:text>, </xsl:text><xsl:value-of select="$apply_from_name"/>
        <xsl:value-of select="../@begin"/>
        <xsl:text> </xsl:text><xsl:value-of select="$name_to"/><xsl:text> </xsl:text>
        <xsl:value-of select="../@end"/>
        <xsl:if test="@name!=''">
          <xsl:text> </xsl:text><xsl:value-of select="$for_zone_name"/><xsl:text> "</xsl:text>
          <xsl:value-of select="@name"/>
          <xsl:text>"</xsl:text>
        </xsl:if>
        <xsl:if test="count(../../../../Typeuse) &gt; 1">
          <xsl:text> </xsl:text>
          <xsl:value-of select="../../../@name"/>
        </xsl:if>
      </xsl:attribute>
      <xsl:apply-templates select="Tariffs/Item" mode="tariff_summary"/>
    </div>
  </xsl:template>


  <xsl:template match="CommonCardYears//Tariffs/Item" mode="tariff_summary">
    <xsl:if test="position()!=1">|</xsl:if>
    <xsl:value-of select="@tariff"/>
  </xsl:template>


<!--
  События (Events)
-->
  <xsl:template match="CommonCardYears//Events" >
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="parent_class"/>
    <xsl:variable name="node_class">
      <xsl:choose>
        <xsl:when test="name(..) = 'Month'"><xsl:value-of select="$parent_class"/></xsl:when>
        <xsl:otherwise><xsl:value-of select="concat($parent_class, '_', position())"/></xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <xsl:apply-templates >
      <xsl:with-param name="level"><xsl:value-of select="$level"/></xsl:with-param>
      <xsl:with-param name="parent_class" select="$node_class"/>
    </xsl:apply-templates>
  </xsl:template>


  <!--
    (TR)
    Событие (Events/Event)
  -->
  <xsl:template match="CommonCardYears//Events//*">
    <xsl:param name="level">0</xsl:param>
    <xsl:param name="parent_class"/>
    <!--xsl:variable name="node_class" select="concat($parent_class, '_', position())"/-->
    <xsl:variable name="node_class" select="$parent_class"/>
    <tr>
      <xsl:attribute name="class">Event</xsl:attribute>
      <td>&#160;</td>
      <td>
        <xsl:attribute name="colspan"><xsl:value-of select="$total_columns_count - 1" /></xsl:attribute>
        <xsl:apply-templates mode="events"/>
      </td>
    </tr>
  </xsl:template>



<!--
  ____________________________________ События ____________________________________
-->
  <xsl:variable name="warn_unknown_node_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Увага! Невідомий вузол</xsl:when>
          <xsl:otherwise>Внимание! Неизвестный узел</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="warn_developers_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Будь ласка, повідомте розробникам програми про це повідомленні</xsl:when>
          <xsl:otherwise>Пожалуйста, сообщие разработчикам программы об этом сообщении</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="counter_setup_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Встановлено лічильник</xsl:when>
          <xsl:otherwise>Установлен счетчик</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="counter_shutdown_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Знято лічильник</xsl:when>
          <xsl:otherwise>Снят счетчик</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="counter_setup_val_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">показання встановлення</xsl:when>
          <xsl:otherwise>показание установки</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="counter_shutdown_val_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">показання зняття</xsl:when>
          <xsl:otherwise>показание снятия</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="setup_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Встановлено</xsl:when>
          <xsl:otherwise>Установлен</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="shutdown_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Знято</xsl:when>
          <xsl:otherwise>Снят</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="saldo_minus_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Списано з сальдо на суму</xsl:when>
          <xsl:otherwise>Списано с сальдо на сумму</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:variable name="saldo_plus_name">
      <xsl:choose>
          <xsl:when test="$lang = 'uk'">Дораховано на суму</xsl:when>
          <xsl:otherwise>Доначислено на сумму</xsl:otherwise>
      </xsl:choose>
  </xsl:variable>

  <xsl:template match="Event/*" mode="events">
    <span class="error">
    <xsl:text> --- </xsl:text><xsl:value-of select="$warn_unknown_node_name"/><xsl:text> &lt;</xsl:text>
    <xsl:value-of select="name(.)" />
    <xsl:text>&gt;. </xsl:text><xsl:value-of select="$warn_developers_name"/><xsl:text> --- </xsl:text>
    </span>
  </xsl:template>

  <!--
    Установка счетчика
  -->
  <xsl:template match="Event/MountCounter" mode="events">
    <xsl:value-of select="$counter_setup_name"/><xsl:text> № </xsl:text>
    <xsl:value-of select="@counterNumber" />
    <xsl:text>, </xsl:text><xsl:value-of select="$counter_setup_val_name"/><xsl:text>: </xsl:text>
    <xsl:apply-templates select="Reading/Scale" />
    <xsl:text> </xsl:text><xsl:value-of select="$name_na"/><xsl:text> </xsl:text>
    <xsl:call-template name="formatdate">
      <xsl:with-param name="datestr" select="@date" />
    </xsl:call-template>
    <xsl:text> </xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
  </xsl:template>


  <!--
    Показания многозонных счетчиков для разных событий (снятие/установка счетчика и т.д.)
  -->
  <xsl:template match="Reading/Scale">
    <xsl:if test="@perekrut">
      <xsl:value-of select="@perekrut" />
      <xsl:text>:</xsl:text>
    </xsl:if>
    <xsl:value-of select="@value" />
    <xsl:if test="position() &lt; count(../*)">
      <xsl:text>/</xsl:text>
    </xsl:if>
  </xsl:template>


  <!--
    Снятие счетчика
  -->
  <xsl:template match="Event/UnMountCounter" mode="events">
    <xsl:value-of select="$counter_shutdown_name"/><xsl:text> № </xsl:text>
    <xsl:value-of select="@counterNumber" />
    <xsl:text>, </xsl:text><xsl:value-of select="$counter_shutdown_val_name"/><xsl:text>: </xsl:text>
    <xsl:apply-templates select="Reading/Scale" />
    <xsl:text> </xsl:text><xsl:value-of select="$name_na"/><xsl:text> </xsl:text>
    <xsl:call-template name="formatdate">
      <xsl:with-param name="datestr" select="@date" />
    </xsl:call-template>
    <xsl:text> </xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
  </xsl:template>


  <!--
    Установка группового счетчика
  -->
  <xsl:template match="Event/MountGroupCounter" mode="events">
    <xsl:value-of select="$setup_name"/><xsl:text> </xsl:text>
    <xsl:value-of select="@type" />
    <xsl:text>, </xsl:text>
    <xsl:value-of select="@servicename" />
    <xsl:text>, № </xsl:text>
    <xsl:value-of select="@counterNumber" />
    <xsl:text>, </xsl:text>
    <xsl:call-template name="formatdate">
      <xsl:with-param name="datestr" select="@date" />
    </xsl:call-template>
    <xsl:text> </xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
  </xsl:template>


  <!--
    Снятие группового счетчика
  -->
  <xsl:template match="Event/UnMountGroupCounter" mode="events">
    <xsl:value-of select="$shutdown_name"/><xsl:text> </xsl:text>
    <xsl:value-of select="@type" />
    <xsl:text>, </xsl:text>
    <xsl:value-of select="@servicename" />
    <xsl:text>, № </xsl:text>
    <xsl:value-of select="@counterNumber" />
    <xsl:text>, </xsl:text>
    <xsl:call-template name="formatdate">
      <xsl:with-param name="datestr" select="@date" />
    </xsl:call-template>
    <xsl:text> </xsl:text><xsl:value-of select="$year"/><xsl:text>.</xsl:text>
  </xsl:template>

  <!--
    Списание сальдо
  -->
  <xsl:template match="Event/WriteOffSaldo" mode="events">
    <xsl:value-of select="$saldo_minus_name"/><xsl:text>: </xsl:text>
    <xsl:value-of select="@sum" />
    <xsl:text> </xsl:text>
    <xsl:value-of select="$money_unit"/>
    <xsl:text>. </xsl:text><xsl:value-of select="$name_za"/><xsl:text> </xsl:text>
    <xsl:value-of select="@monthName"/>
  </xsl:template>


  <!--
    Доначисленно сальдо
  -->
  <xsl:template match="Event/AddSaldo" mode="events">
    <xsl:value-of select="$saldo_plus_name"/><xsl:text>: </xsl:text>
    <xsl:value-of select="@sum" />
    <xsl:text> </xsl:text>
    <xsl:value-of select="$money_unit"/>
    <xsl:text>. </xsl:text><xsl:value-of select="$name_za"/><xsl:text> </xsl:text>
    <xsl:value-of select="@monthName"/>
  </xsl:template>


  <!--
    Статусы показаний
      "0": "начальное"
      "1": "контрольное"
      "2": "из квитанции"
      "3": "со слов абонента"
      "4": "расчетное"
      "5": "прогнозируемое"
  -->
  <xsl:template match="ReadingBeg|ReadingEnd" mode="readings_status">
    <xsl:variable name="reading_cstatus" select="@type" />
    <span class="hint readings_hint">
      <xsl:attribute name="title">
        <xsl:value-of select="$l_r_type"/>
        <xsl:text>: </xsl:text>
        <xsl:choose>
          <xsl:when test="$reading_cstatus = 'старт' or $reading_cstatus = '0'"><xsl:value-of select="$l_r_start_full"/></xsl:when>
          <xsl:when test="$reading_cstatus = 'контр' or $reading_cstatus = '1'"><xsl:value-of select="$l_r_contr_full"/></xsl:when>
          <xsl:when test="$reading_cstatus = '2'"><xsl:value-of select="$l_r_abon_pay_full"/></xsl:when>
          <xsl:when test="$reading_cstatus = 'абон' or $reading_cstatus = '3'"><xsl:value-of select="$l_r_abon_full"/></xsl:when>
          <xsl:when test="$reading_cstatus = '4'"><xsl:value-of select="$l_r_calc_full"/></xsl:when>
          <xsl:when test="$reading_cstatus = '6'"><xsl:value-of select="$l_r_calc_full"/></xsl:when>
          <xsl:when test="$reading_cstatus = 'расч' or $reading_cstatus = '5'"><xsl:value-of select="$l_r_calc_plan_full"/></xsl:when>
        </xsl:choose>
      </xsl:attribute>

      <xsl:text>(</xsl:text>
      <xsl:choose>
        <xsl:when test="$reading_cstatus = 'старт' or $reading_cstatus = '0'"><xsl:value-of select="$l_r_start_symb"/></xsl:when>
        <xsl:when test="$reading_cstatus = 'контр' or $reading_cstatus = '1'"><xsl:value-of select="$l_r_contr_symb"/></xsl:when>
        <xsl:when test="$reading_cstatus = '2'"><xsl:value-of select="$l_r_abon_pay_symb"/></xsl:when>
        <xsl:when test="$reading_cstatus = 'абон' or $reading_cstatus = '3'"><xsl:value-of select="$l_r_abon_symb"/></xsl:when>
        <xsl:when test="$reading_cstatus = '4'"><xsl:value-of select="$l_r_calc_symb"/></xsl:when>
        <xsl:when test="$reading_cstatus = '6'"><xsl:value-of select="$l_r_calc_symb"/></xsl:when>
        <xsl:when test="$reading_cstatus = 'расч' or $reading_cstatus = '5'"><xsl:value-of select="$l_r_calc_plan_symb"/></xsl:when>
        <xsl:otherwise><xsl:value-of select="$reading_cstatus" /></xsl:otherwise>
      </xsl:choose>
      <xsl:text>)</xsl:text>
    </span>
    <xsl:text>&#160;</xsl:text>
  </xsl:template>


<!-- ########################################################################## -->

    <xsl:template name="styles">
        <style type="text/css">
          <xsl:text disable-output-escaping="yes">
<![CDATA[
body {
  margin: 2px;
  background-color: #ffffff;
  color: #000000;
}
table {
  width: 100%;
  border-collapse: collapse;
  border: 1px solid #aaa;
}
th {
  text-align: center;
  border: 1px solid #aaa;
  font-weight: normal;
  padding: 2px;
}
tr {
  font-family: verdana,tahoma;
  font-size: 10pt;
  text-align: left;
  vertical-align: top;
  padding: 2px;
}
tr.altmonth {
  background: #d0f0d0;
}
tr.total,
tr.total {
  background: #ffbcbc;
  border: 1px solid #aaa;
  padding: 2px 7px;
}
tr.total th {
  text-align: left;
}
tr.info {
  background: #ffffbc;
  text-align: left;
}
td {
  padding: 2px;
}

.error th,
.error td { color: #f00; }

.hide_node { display: none; }

.hint { font-size: smaller; cursor: help; }
span.error { color: #f00; }

#table_summary { margin-bottom: 10px;}
#table_summary .show-or-hide {
  float: right;
}

  table.summary th {
    width: 200px;
    background-color: #fff;
    text-align: left;
    border: none;
  }
  table.summary td {
    border:none;
  }
  table.summary tr.altrow th,
  table.summary tr.altrow {
    background-color: #f0f0f0;
  }

  table.data tbody td {
    border: 1px solid #aaa;
    padding: 2px 7px;
    vertical-align: middle;
  }
  td.string { text-align: left; }
  td.period { max-width: 70px; text-align: center; }
  td.number { max-width: 100px; text-align: right; }
  tr.yearSummary { background: #f8e0b5; font-weight: bold; }
  tr.yearSeparator { background: #fbf4d9; }

  .nowrap { white-space: nowrap; }

  table.data td.left_half { border-right: none; padding-right: 0; text-align:right;}
  table.data td.right_half { border-left: none; padding-left: 0; text-align:left;}

br {
  font-size: 4pt;
}
ul {
  margin-top: 1pt;
  margin-bottom: 1pt;
}

  .for_print_only { display: none; }
  @media print {
    .for_print_only { display: block; }
  }

/* table.data */
.data th         { background: #DBE4ED; vertical-align: middle; }
.data tr         { background-color: #fff;    }
.data tr.altrow  { background-color: #f0f0f0; }

/* table.common_card */
.common_card .hide_node { display: none; }
.common_card .hint { font-size: smaller; cursor: help; font-weight: normal; color: #666; }
.common_card .nowrap { white-space: nowrap; }

.common_card .level_1  td.name {  }
.common_card .level_2  td.name { padding-left: 20px; }
.common_card .level_3  td.name { padding-left: 40px; }
.common_card .level_4  td.name { padding-left: 60px; }
.common_card .level_5  td.name { padding-left: 80px; }
.common_card .level_6  td.name { padding-left: 100px; }
.common_card .level_7  td.name { padding-left: 120px; }
.common_card .level_8  td.name { padding-left: 140px; }
.common_card .level_9  td.name { padding-left: 180px; }
.common_card .level_10 td.name { padding-left: 200px; }

.common_card .level_1  { background-color: #f1fcf2; }
.common_card .level_1.altrow  { background-color: #def7de; }

#commonCardData .LastRevisionAct,
#commonCardData .BeginingSaldo,
#commonCardData .Year  { background: #ffe19c; font-weight: bold; }
.common_card .Event td { background: #e3e3ff; }
.common_card .Period td { border-top-width: 2px; }
.common_card .Info td { border-top-width: 1px; }

#hide_abcode_details,
#show_abcode_details,
.common_card .toggle_rows,
.common_card .show-or-hide,
.common_card .no_img {
  float: left;
  height: 14px;
  width: 14px;
  margin-right: 5px;
  font: bold 9px/14px Verdana, Tahoma, sans-serif;
  text-align: center;
  color: #666;
}

#hide_abcode_details,
#show_abcode_details,
.common_card .toggle_rows,
.common_card .show-or-hide {
  background-repeat: no-repeat;
  background-image: url(cc_sprite.gif);
  background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAIAAAD9b0jDAAAACXBIWXMAAAsSAAALEgHS3X78AAABEElEQVR4nN1UQQqEMAz04I98liAiiHgVREQQEfyVfsNfKJslEENSNaK7sDugNMl0mtY6/jiO3tPw4QmC4JQ3TZOd+RZd19XYgpHpEA3DEN7DMNwSXZZFF+xJt6hzfXvySDRJEl6I4xgHbdsKUcEkEHN3+wReNTK3Tuu6xlSWZTzkWxZMAWJ++EwfFhUnVRSFTiLuXiknLnQ6z7NR1Mj0jXKX8NMu9W1RcaWiKIJ33/cOUaSig3RdRzWd4cuT44A05zg6BSqaDVmR/vc9l6VxM9s6bZomTVMxAZLapZCGVQphFoayU7AftCgKxXHzkKo0a9elqqrK8xwH+gNiBkp61pEooCxLndSdHuDc+Tn+zqVei1sZzEBKRK8AAAAASUVORK5CYII=);
  cursor: pointer;
  background-color: #f8f8f8;
  text-indent: -9999px;
  border: 1px solid #666;
}
  #hide_abcode_details,
  .common_card .toggle_rows { background-position: -14px 0; }
  #show_abcode_details,
  .common_card .closed .toggle_rows { background-position: 0 0; }
  .common_card .show-or-hide { background-position: 0 -14px; }
  .common_card .show-or-hide { background-position: 0 -14px; }
  .common_card .showed .show-or-hide { background-position: -14px -14px; }

  #hide_abcode_details:hover,
  #show_abcode_details:hover,
  .common_card .toggle_rows:hover,
  .common_card .show-or-hide:hover {
    border-color: #f00;
  }

  #hide_abcode_details,
  #show_abcode_details {
    float: right;
  }
  .common_card .no_img {
    padding: 1px;
  }

  #commonCardData td.showed {
    border-bottom-color: #fef8cf;
    background-color: #fef8cf;
  }
  .common_card .Info td { background: #fef8cf; padding: 5px 10px 10px; }

.common_card tr.Month td { font-weight: bold;  }
.common_card tr.Month.closed td { font-weight: normal; }*/

.common_card th {vertical-align: middle;}
.common_card tbody th {font-size: 10px;}

table#commonCardData tr:hover { background: #ffffcc; }

    @media print {
      table.summary th,
      table.summary td,
      table#commonCardData th,
      table#commonCardData td { background: #fff; font-size: 8pt; }
      table#commonCardData .toggle_rows,
      table#commonCardData .show-or-hide,
      table#commonCardData .no_img{ display: none; }

      #commonCardData td.showed {
        border-bottom-color: #fff;
        background-color: #fff;
      }
    }

  td.readings {
    text-align: left;
  }
  td.readings div {
    position: relative;
  }

/*
  td.cstatus_абон,
  td.cstatus_контр,
  td.cstatus_3, .cstatus_2,
  td.cstatus_1 { font-weight: bold; }
*/

  td.cstatus_контр .readings_hint,
  td.cstatus_1 .readings_hint { color: #00f;  }
  td.cstatus_2 .readings_hint,
  td.cstatus_абон .readings_hint,
  td.cstatus_3 .readings_hint { color: #000;  }

  .r {
    position: absolute;
    right: -11px;
    top: 50%;
    margin-top: -3px;
  }
    .abon-r,
    .contr-r {
      height: 11px;
      font-weight: bold;
      font-size: 11px;
      line-height: 11px;
    }
    .contr-r { color: #00f; }
    .abon-r { color: #f00; }

#commonCardData .opened {
  background: #d7e593;
}
.common_card td.tariff {
  text-align: left;
  width: 120px;
}
.common_card .Scale td.tariff,
.common_card .Period td.tariff {
  text-align: right;
}

]]>
            </xsl:text>
        </style>
    </xsl:template>

  <xsl:template name="formatdate">
    <xsl:param name="datestr" />
    <!-- Ничего не делаем - формат правильный -->
    <xsl:value-of select="$datestr" />
  </xsl:template>


<!--

-->
  <xsl:template name="scripts">
    <script type="text/javascript">
      <xsl:text disable-output-escaping="yes">
//<![CDATA[

      if (document.getElementsByClassName) {
        function getElementsByClass(classList, node) {
          return (node || document).getElementsByClassName(classList)
        }
      } else {
        function getElementsByClass(classList, node) {
          var node = node || document,
          list = node.getElementsByTagName('*'),
          length = list.length,
          classArray = classList.split(/\s+/),
          classes = classArray.length,
          result = [], i,j
          for(i = 0; i < length; i++) {
            for(j = 0; j < classes; j++)  {
              if(list[i].className.search('\\b' + classArray[j] + '\\b') != -1) {
                result.push(list[i])
                break
              }
            }
          }

          return result
        }
      }


      // Удаление класса
      function removeClassName(obj, class_name) {
        var classArray = obj.className.split(/\s+/),
        length = classArray.length,
        result = [];
        for ( var i = 0; i < length; i++ ) {
          if (classArray[i] != class_name) {
            result.push(classArray[i])
          }
        }

        return result.join(' ')
      }


      //
      function getElementsByClassBegin(class_name, node, reg_ex) {
        var result = []
        var items = node || list
        // Классы для строк разных уровней выглядят след образом:
        //
        //  p_1
        //    p_1_1
        //      p_1_1
        //      p_1_2
        //      ...
        //      p_1_12
        //   p_1_2
        //  p_2
        //  ...
        //
        var reg = reg_ex || '(_\\d+)+'
        for (var i = 0; i < items.length; i++) {
          if (items[i].className.search('\\b' + class_name + reg + '\\b') != -1) {
            result.push(items[i])
          }
        }

        return result
      }


      // Строки таблицы
      list = document.getElementById('commonCardData').getElementsByTagName('tr');


      function toggle_rows(obj) {
        var h = obj.getAttribute('id'),
          imgs = [],
          items = [],
          closed_img = 'cc1',
          opened_img = 'cc2',
          hidden_img = 'cc3',
          showen_img = 'cc4';
        if (hasClass(obj.parentNode.parentNode.className, 'closed')) {
          h = 'p' + h;
          items = getElementsByClassBegin(h);

          // При открытии будем показывать только первый уровень подпунктов
          // Уровни мы определяем по классам, на случай, если какой то уровень пропущен -
          // будем проверять один, два и три символа плюс...
          subitems = getElementsByClassBegin(h, items, '_\\d+')
          if (subitems.length == 0)
            subitems = getElementsByClassBegin(h, items, '_\\d+_\\d+');
          if (subitems.length == 0)
            subitems = getElementsByClassBegin(h, items, '_\\d+_\\d+_\\d+');
          for (j = 0; j < subitems.length; j++) {
            subitems[j].className = removeClassName(subitems[j], 'opened');
            subitems[j].className = removeClassName(subitems[j], 'hide_node');
            if (subitems[j].className.indexOf(' closed') <= 0) {
              subitems[j].className = subitems[j].className + ' closed';
            }
          };
          if (client_template_mode) {
            obj.setAttribute('src', obj.getAttribute('src').replace(closed_img, opened_img));
          }
          obj.className = obj.className.replace(' cc_closed',' cc_opened');
          // объект клика -> ячейка TD -> строка TR
          obj.parentNode.parentNode.className = removeClassName(obj.parentNode.parentNode, 'closed');
          if (obj.parentNode.parentNode.className.indexOf(' opened') <= 0) {
            obj.parentNode.parentNode.className = obj.parentNode.parentNode.className + ' opened';
          }
        } else {
          h = '[p|x]' + h;
          items = getElementsByClassBegin(h);
          for (j = 0; j < items.length; j++) {
            if (items[j].className.indexOf(' hide_node') <= 0) {
              items[j].className = items[j].className + ' hide_node'
            }
            imgs = items[j].getElementsByTagName("i");
            for (k = 0; k < imgs.length; k++) {
              if (client_template_mode) {
                imgs[k].setAttribute('src', imgs[k].getAttribute('src').replace(opened_img, closed_img).replace(showen_img, hidden_img));
              }
              imgs[k].className = imgs[k].className.replace(' cc_opened', ' cc_closed').replace(' cc_showen', ' cc_hidden');
              imgs[k].parentNode.className = removeClassName(imgs[k].parentNode, 'showed');
            }
          };
          if (client_template_mode) {
            obj.setAttribute('src', obj.getAttribute('src').replace(opened_img, closed_img));
          }
          obj.className = obj.className.replace(' cc_opened', ' cc_closed');
          obj.parentNode.parentNode.className = removeClassName(obj.parentNode.parentNode, 'opened');
          if (obj.parentNode.parentNode.className.indexOf(' closed') <= 0) {
            obj.parentNode.parentNode.className = obj.parentNode.parentNode.className + ' closed';
          }
        }
      }

      // Массив ссылок для скрытия-показа строк таблицы
      a = getElementsByClass('toggle_rows', document.getElementById('commonCardData'));

      //
      for (var i = 0; i < a.length; i++) {
        a[i].onclick = function() {
          toggle_rows(this)
        }
      };


      a_2 = getElementsByClass('show-or-hide');

      for (var i = 0; i < a_2.length; i++) {
        a_2[i].onclick = function() {
          var
            h, row,
            hidden_img = 'cc3',
            showen_img = 'cc4';
          // ID объекта для скрытия/отображения передаем в ID картинки для клика,
          // но с добавленным первым символом.
          h = this.getAttribute('id').substr(1);
          row = document.getElementById(h);
          if (hasClass(this.parentNode.className, 'showed')) {
            if (row.className.indexOf(' hide_node') <= 0) {
              row.className = row.className + ' hide_node'
            }
            this.parentNode.className = removeClassName(this.parentNode, 'showed');
            if (client_template_mode) {
              this.setAttribute('src', this.getAttribute('src').replace(showen_img, hidden_img));
            }
            this.className = this.className.replace(' cc_showen', ' cc_hidden');
          } else {
            row.className = removeClassName(row, 'hide_node');
            if (row.className.indexOf(' showed') <= 0) {
              this.parentNode.className = this.parentNode.className + ' showed';
            }
            if (client_template_mode) {
              this.setAttribute('src', this.getAttribute('src').replace(hidden_img, showen_img));
            }
            this.className = this.className.replace(' cc_hidden', ' cc_showen');

            if (with_external_requests == true) {
              var
                tds, tag_name, i;
                tds = row.getElementsByTagName('td');
                tag_name = h.substr(0,h.indexOf(':'));
                i = (tag_name == 'spi' || tag_name == 'sri') ? 1 : 0;
                if (tds[i].innerText == '') {
                  tds[i].innerHTML = window.external.getexinfo(h);
                }
              }
            }
        }
      };

      function hasClass(node_class, class_name) {
        if (node_class.search('\\b' + class_name + '\\b') != -1) {
          return true
        } else {
          return false
        }
      }


      a_to_show = getElementsByClass('lvl_0');
      for ( i = 0; i < a_to_show.length; i++) {
        a_to_show[i].click();
        a_to_show[i].click();
      }


      if (expanded) {
        a_to_show = getElementsByClass('lvl_1');
        for ( i = 0; i < a_to_show.length; i++) {
          a_to_show[i].click();
        }
      }


      if (document.getElementById('show_abcode_details')) {
        document.getElementById('show_abcode_details').onclick = function(){
          document.getElementById('abcode_short_info').className = document.getElementById('abcode_short_info').className + ' hide_node';
          document.getElementById('abcode_details').className = removeClassName(document.getElementById('abcode_details'), 'hide_node');
        }

        document.getElementById('hide_abcode_details').onclick = function(){
          document.getElementById('abcode_details').className = document.getElementById('abcode_details').className + ' hide_node';
          document.getElementById('abcode_short_info').className = removeClassName(document.getElementById('abcode_short_info'), 'hide_node');
        }

        if (!heading_expand) {
          document.getElementById('hide_abcode_details').click();
        }
      }
 //]]>
      </xsl:text>
    </script>
  </xsl:template>

</xsl:stylesheet>
