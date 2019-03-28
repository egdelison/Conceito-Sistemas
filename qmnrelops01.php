<?php
	/*----------------------------------------------------------------------------*/
	/* Programa: qmnrelops01.php                                                  */
	/* Tipo....: HTML(Html ou Flex)	                                              */                         
	/* Função..: Regras de negócio de manutenção de qualidade por OP detalhado    */
	/* Data....: 22/11/2018			                                              */
	/* Autor...: Elison Goulart Duarte	                                          */
	/* Sistema.: (QMS - Relatórios)												  */
	/* Processo: Regras de negócio de manutenção de qualidade por OP detalhado    */
	/* Revisões: Data       Autor          Observação                   Versão    */
	/*----------------------------------------------------------------------------*/
	/*			 21/01/2019 Daniel Mezzari - Ajustada a rega de negócio			  */			
	/*----------------------------------------------------------------------------*/

    include('sinproweb04.php');
	include('sinproxml01.php');
	require('sinpropdf01.php');
	require('sinprogen01.php');
	include('prnprogen01.php');
	
   // Variaveis para tradução
    $TBL = "";
    $BTN = "";
    $MSG = "";
    $TXT = "FILTRO";

    // Seta a tradução conforme variáveis acima
    set_translate($TBL,$BTN,$MSG,$TXT);

    open_db("dbadm");

    	if($FRWAction == "RELATORIO")
		{
			class PDF extends FPDF
			{
				//Cabecalho
				function Header()
				{
					global $CHorientacao, $CHfonte,$SHempraz,$CHFRWmenutit,$CHorientacao,$CMBAgrupador;
				
					$ARRTipoRel['0'							  ] = 'Geral';
					$ARRTipoRel['R'							  ] = 'Resumido';
					$ARRTipoRel['dbind.indproduto.seqmarca_bi'] = 'Por marca';
					$ARRTipoRel['dbadm.qmsitedoc.seqpesso_bi' ] = 'Por prestadora';
					$ARRTipoRel['dbadm.qmsitedoc.seqcla_bi'   ] = 'Por tipo de defeito';
					$ARRTipoRel['dbadm.qmsitedoc.itetipo_in'  ] = 'Por tipo de apontamento';
					
					pdf_def_header($SHempraz, 'Relatório de controle de defeitos [' . $ARRTipoRel[$CMBAgrupador] . ']' , $CHfonte, $CHorientacao);
				}
			 
				function Footer()
				{
					pdf_def_footer();
				}
			}
		
			$CHfonte      = '09';
    		
    		if ($CMBAgrupador == "R")
    			 $CHorientacao = 'P';
    		else $CHorientacao = 'L';
			
			open_pdf($CHorientacao, '', '', '', $CHfonte);
				
				if ($CHKFiltros == "1")
				{
					pdf_set_subtitle(get_translate_text("#FILTRO"));
        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('70','10', 'OP n°','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($INCodOps != "")
			        	 pdf_def_lin_text('80','10', $INCodOps,'0','0','L','0','');
			        else pdf_def_lin_text('80','10', 'Todas','0','0','L','0','');

			        if ($CMBAgrupador != "R") pdf_def_lin_text('120','10', '','0','0','L','0','');
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('60','10', 'Situação OPs','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($CHSitSel != "")
			        	 pdf_def_lin_text('100','10', $CHSitSel,'0','0','L','0','');
			        else pdf_def_lin_text('100','10', 'Todas','0','0','L','0','');
			        
			        if ($CMBAgrupador != "R") pdf_def_lin_text('120','10', '','0','0','L','0','');
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('55','10', 'Apontamento','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($DTIni != "")
			        	 pdf_def_lin_text('60','10', $DTIni,'0','0','L','0','');
			        else pdf_def_lin_text('60','10', '...' ,'0','0','L','0','');
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('20','10', 'Até','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($DTFim != "")
			        	 pdf_def_lin_text('50','10', $DTFim,'0','0','L','0','');
			        else pdf_def_lin_text('50','10', '...' ,'0','0','L','0','');
			        
			        pdf_def_break_line(10,1);
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('70','10', 'Marca','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($CHMarSel != "")
			        	 pdf_def_area_text('','10',utf8_decode($CHMarSel),'0','L','');
			        else pdf_def_area_text('','10','Todas','0','L','');
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('70','10', 'Referência','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($EDTBISeqRef != "")
			        	 pdf_def_area_text('','10',utf8_decode($EDTBISeqRef),'0','L','');
			        else pdf_def_area_text('','10','Todas','0','L','');
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('70','10', 'Prestadora','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($EDTBISeqPre != "")
			        	 pdf_def_area_text('','10',utf8_decode($EDTBISeqPre),'0','L','');
			        else pdf_def_area_text('','10','Todas','0','L','');
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('70','10', 'Tipos de defeitos','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($EDTBISeqDef != "")
			        	 pdf_def_area_text('','10',utf8_decode($EDTBISeqDef),'0','L','');
			        else pdf_def_area_text('','10','Todos','0','L','');
			        
			        pdf_set_font('Arial','B','8');
			        pdf_def_lin_text('70','10', 'Tipo de Apont.','0','0','L','0','');
			        pdf_def_lin_text('8' ,'10', ':','0','0','C','0','');
			        
			        pdf_set_font('Arial','','8');
			        if ($CHTipSel != "")
			        	 pdf_def_area_text('','10',utf8_decode($CHTipSel),'0','L','');
			        else pdf_def_area_text('','10','Todos','0','L','');
			        
			        pdf_def_break_line(10,1);
					pdf_def_color(225,225,225);
					if ($CMBAgrupador == "R")
						 pdf_def_line(30,pdf_get_line() - 5,565,pdf_get_line() -5,'0.5');
					else pdf_def_line(30,pdf_get_line() - 5,813,pdf_get_line() -5,'0.5');
				}
			
    			$ARRTipo[3] = "Remonte"; 
    			$ARRTipo[4] = "Perda";
    			$ARRTipo[5] = "LD";
    			
    			$INGerDef = 0;
    			$DCGerCla = 0;
    			$DCGerPer = 0;
    			$INGerReg = 0;
    			
    			$CHWhrAgr   = "";
    			
    			$CHWhrOps = intval($INCodOps) > 0  ? " dbsis.sisrelnumuni.numunico_dc = $INCodOps     AND " : " ";
    			$CHWhrSts = $CMBSitOps 		 != "" ? " dbind.inddocto.docstatus_in   IN ($CMBSitOps)  AND " : " ";
    			$CHWhrMar = $CMBMarca        != "" ? " AND dbind.indproduto.seqmarca_bi  IN ($CMBMarca)  "  : " ";
    			$CHWhrRef = $BISeqRef		 != "" ? " dbind.inddocto.seqrefer_dc    IN ($BISeqRef)   AND " : " ";
    			$CHWhrPre = $BISeqPre		 != "" ? " dbadm.qmsitedoc.seqpesso_bi   IN ($BISeqPre)   AND " : " ";
    			$CHWhrDef = $BISeqDef		 != "" ? " dbadm.qmsitedoc.seqcla_bi     IN ($BISeqDef)   AND " : " ";
    			$CHWhrTip = $CMBTipoDef		 != "" ? " dbadm.qmsitedoc.itetipo_in    IN ($CMBTipoDef) AND " : " ";
    			
    			$CHWhrDt1 = ""; 
    			$CHWhrDt2 = "";
    			
    			if ($DTIni != "") $CHWhrDt1 = " dbind.inddocto.docdata_dt >= '" . format_date_db($DTIni) . "' AND ";	
    			if ($DTFim != "") $CHWhrDt2 = " dbind.inddocto.docdata_dt <= '" . format_date_db($DTFim) . "' AND ";
    			
    			$ARRQtdOps = array();
    			$ARRQtdGer = array();
    			
    			if ($CMBAgrupador == "R")
    			{
    				$INTotPec  = 0;
    				$INTotPro  = 0;
    				$INTotFat  = 0;
    				$INTotSob  = 0;
    				$INTotDef  = 0;
    				$INTotRem  = 0;
    				$INTotPer  = 0;
    				
    				$SQLOrdPro = define_sql("SELECT dbind.inddocto.seqdocto_dc,
													dbind.inddocto.seqdocori_bi,
													dbind.inddocto.seqrefer_dc
                                               FROM dbind.inddocto                                                
                                              WHERE dbind.inddocto.seqempre_dc = $SHempcod   	             		AND
                                                    dbind.inddocto.seqtipbas_bi  = 4                           		AND
                                                    dbind.inddocto.seqtipos_dc   = 91                          		AND
													dbind.inddocto.docstatus_in <> 78							    AND
                                                    dbind.inddocto.docdata_dt   >= '" . format_date_db($DTIni) . "' AND 
                                                    dbind.inddocto.docdata_dt   <= '" . format_date_db($DTFim) . "'");

                	if ($SQLOrdPro)
                	{
                		while ($RESOrdPro = $SQLOrdPro->fetch(PDO::FETCH_ASSOC))
    					{    
    						$ARRQtdes = FUNBuscaQuantidades($RESOrdPro['seqdocto_dc']);
    						
    						$INTotPec += $ARRQtdes['INQtdeOri'];
					        $INTotPro += $ARRQtdes['INQtdePro'];
					        $INTotDef += $ARRQtdes['INQtdeDef'];
					        $INTotPer += $ARRQtdes['INQtdePer'];
					        $INTotRem += $ARRQtdes['INQtdeRem'];
					        
					        // Busca a quantidade entregue do pedido relacionado com a OP
					        $SQLEntregue = define_sql("SELECT SUM(dbadm.admitedoc.iteqtent_dc) as qtdent_in
														 FROM dbind.indreldoc, dbadm.admitedoc
													    WHERE dbind.indreldoc.seqdocto_bi	  = {$RESOrdPro['seqdocori_bi']}    AND
															  dbind.indreldoc.seqtipba_bi	  = 4							   AND
															  dbind.indreldoc.seqtipos_bi    IN (34,299) 					   AND
															  dbind.indreldoc.seqtipbaori_bi  = 12							   AND
															  dbind.indreldoc.seqtiposori_bi  = 130							   AND
															  dbadm.admitedoc.seqdocto_dc     = dbind.indreldoc.seqdoctoori_bi AND
															  dbadm.admitedoc.seqite_dc       = dbind.indreldoc.seqiteori_bi");
					        $RESEntregue = $SQLEntregue->fetch(PDO::FETCH_ASSOC);
					        $INTotFat   += $RESEntregue['qtdent_in'];
    					}
                	}
                	
                	$INTotSob = $INTotPec - $INTotFat - $INTotDef - $INTotRem - $INTotPer;
                	
                	$DCPerFat = ($INTotFat / $INTotPec) * 100;
                	$DCPerSob = ($INTotSob / $INTotPec) * 100;
                	$DCPerDef = ($INTotDef / $INTotPec) * 100;
                	$DCPerPer = ($INTotPer / $INTotPec) * 100;
                	$DCPerRem = ($INTotRem / $INTotPec) * 100;
    				
    				pdf_set_subtitle("RESUMO");
    				
    				comBG(); pdf_def_lin_text('150','10', 'Total de peças do período'		  ,'1','0','L',1,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($INTotPec, "0")	  ,'1','0','R',0,'');
    				semBG(); pdf_def_lin_text('60','10' , '100%'							  ,'1','1','R',0,'');
    				
    				comBG(); pdf_def_lin_text('150','10', 'Total de peças faturadas'		  ,'1','0','L',1,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($INTotFat, "0")	  ,'1','0','R',0,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($DCPerFat, "2") . "%",'1','1','R',0,'');
    				
    				comBG(); pdf_def_lin_text('150','10', 'Total de peças de sobra' 		  ,'1','0','L',1,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($INTotSob, "0")	  ,'1','0','R',0,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($DCPerSob, "2") . "%",'1','1','R',0,'');
	    			
    				comBG(); pdf_def_lin_text('150','10', 'Total de peças LD'				  ,'1','0','L',1,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($INTotDef, "0")	  ,'1','0','R',0,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($DCPerDef, "2") . "%",'1','1','R',0,'');
    				
    				comBG(); pdf_def_lin_text('150','10', 'Total de peças remonte'			  ,'1','0','L',1,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($INTotRem, "0")	  ,'1','0','R',0,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($DCPerRem, "2") . "%",'1','1','R',0,'');
    				
    				comBG(); pdf_def_lin_text('150','10', 'Total de peças perdidas'			  ,'1','0','L',1,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($INTotPer, "0")	  ,'1','0','R',0,'');
    				semBG(); pdf_def_lin_text('60','10' , format_decimal($DCPerPer, "2") . "%",'1','1','R',0,'');
	    			
    				pdf_def_break_line(5,1);
    				
    				pdf_set_font('Arial','I','8');
		            pdf_def_color_text('0','0','0');
		            pdf_def_lin_text('' ,'10','Este resumo considera todas as OPs dentro do período informado, mesmo que não tenha sido classifacada no controle de defeitos.','','0','L',1,'');
    				
					pdf_def_break_line(20,1);

    				foreach($ARRTipo as $INTipoApt=>$CHTextoApt)
    				{    				
    					pdf_set_font('Arial','BU','10');
    					pdf_def_lin_text('70','12',"Tipo de apontamento: {$CHTextoApt}" ,'0','1','L','0','');
    					
						imprimeCabecalhoResumido();
						
    					$SQLDefeitos = define_sql("SELECT dbadm.qmsitedoc.itetipo_in,
														  dbind.indfase.fastitulo_ch,
														  dbadm.qmsdefeitos.seqdefeito_bi, 
														  dbadm.qmsdefeitos.defdescri_ch,
														  SUM(dbadm.qmsdefeitos.defclasse_in) AS qtdclasse_in, 
														  SUM(dbadm.qmsitedoc.iteqtde_in) 	  AS qtddefeito_in
											
													 FROM dbadm.qmsdocto, dbsis.sisrelnumuni, dbind.inddocto, 
														  dbind.indrefer LEFT JOIN dbind.indproduto 
																				ON dbind.indproduto.seqrefer_dc = dbind.indrefer.seqrefer_dc																		   
																		INNER JOIN dbadm.admmarca
																				ON dbadm.admmarca.seqmarca_bi = dbind.indproduto.seqmarca_bi 
		    																	   $CHWhrMar,
		
														  dbadm.qmsitedoc, dbadm.admpessoa, dbind.indfase, dbadm.qmsdefeitos
													WHERE dbadm.qmsdocto.seqempre_bi 	  = $SHempcod 						AND 
														  dbadm.qmsdocto.seqtipba_bi 	  = 35        						AND 
														  dbadm.qmsdocto.seqtipos_bi 	  = 369		  						AND 
														  dbsis.sisrelnumuni.seqempre_dc  = dbadm.qmsdocto.seqempre_bi  	AND 
		                                                  dbsis.sisrelnumuni.seqtipba_dc  = 4 						    	AND 
		                                                  dbsis.sisrelnumuni.seqtipos_dc  = 91 								AND 
		                                                  dbsis.sisrelnumuni.numcodgen_dc = dbadm.qmsdocto.seqdocori_bi 	AND 
														  $CHWhrOps
														  dbind.inddocto.seqdocto_dc	  = dbsis.sisrelnumuni.numcodgen_dc AND 
													      dbind.inddocto.seqtipbas_bi	  = dbsis.sisrelnumuni.seqtipba_dc  AND 
														  dbind.inddocto.seqtipos_dc	  = dbsis.sisrelnumuni.seqtipos_dc  AND 
														  $CHWhrDt1
		    											  $CHWhrDt2
														  $CHWhrRef
														  $CHWhrSts
														  dbind.indrefer.seqrefer_dc      = dbind.inddocto.seqrefer_dc		AND 
														  dbadm.qmsitedoc.seqdocto_bi	  = dbadm.qmsdocto.seqdocto_bi	    AND
														  dbadm.qmsitedoc.itetipo_in	  = $INTipoApt						AND
														  $CHWhrPre
		    											  $CHWhrTip
														  dbadm.admpessoa.seqpesso_dc     = dbadm.qmsitedoc.seqpesso_bi	    AND 
														  dbind.indfase.seqfase_dc	      = dbadm.qmsitedoc.seqfase_bi		AND 
														  $CHWhrDef
														  dbadm.qmsdefeitos.seqdefeito_bi = dbadm.qmsitedoc.seqcla_bi
												 GROUP BY dbadm.qmsitedoc.seqfase_bi,
													      dbadm.qmsitedoc.seqcla_bi
												 ORDER BY $CMBOrdemResum");
						$RESDefeitos = $SQLDefeitos->fetchAll(PDO::FETCH_ASSOC);

		    			$INTotDef = 0;
		    			foreach($RESDefeitos as $ARRItem)
		    			{
							$INTotDef += $ARRItem['qtddefeito_in'];	
							$INGerDef += $ARRItem['qtddefeito_in'];
		    			}
		    			
		    			$INQtdIte = 0;
		    			$INTotCla = 0;
		    			foreach($RESDefeitos as $ARRItem)
		    			{

							$SQLBusGruDef = define_sql("SELECT dbadm.qmsgrupo.grutitulo_ch,
															   dbadm.qmsgrupo.seqgrupo_in
														  FROM dbadm.qmsreldefgru
												    INNER JOIN dbadm.qmsdefeitos
															ON dbadm.qmsdefeitos.seqdefeito_bi = dbadm.qmsreldefgru.seqdefeito_in
													INNER JOIN dbadm.qmsgrupo
															ON dbadm.qmsgrupo.seqgrupo_in = dbadm.qmsreldefgru.seqgrupo_bi
														 WHERE dbadm.qmsreldefgru.seqdefeito_in = {$ARRItem['seqdefeito_bi']}");
							$RESGrupoDef = $SQLBusGruDef->fetch(PDO::FETCH_ASSOC);

							$ARRGrupos[$RESGrupoDef['seqgrupo_in']]['desc']  = $RESGrupoDef['grutitulo_ch'];
							$ARRGrupos[$RESGrupoDef['seqgrupo_in']]['qtde'] += $ARRItem['qtddefeito_in'];
							$ARRDefeitos[$RESGrupoDef['seqgrupo_in']][$ARRItem['seqdefeito_bi']]['desc']  = $ARRItem['defdescri_ch'];
							$ARRDefeitos[$RESGrupoDef['seqgrupo_in']][$ARRItem['seqdefeito_bi']]['qtde'] += $ARRItem['qtddefeito_in'];

							$RESGrupoDef['grutitulo_ch'] = strlen($RESGrupoDef['grutitulo_ch'])> 30 		  ? 
														   substr($RESGrupoDef['grutitulo_ch'],0, 27) . "..." : 
														   $RESGrupoDef['grutitulo_ch'];

	    					$INMedCla = format_decimal($ARRItem['qtdclasse_in'] / $ARRItem['qtddefeito_in'], "0");
	    					$DCPerDef = format_decimal(($ARRItem['qtddefeito_in'] / $INTotDef) * 100, "2");
	    					$INTotCla += $INMedCla;
							$INQtdIte ++;
							
							pdf_def_lin_text('80'  ,'10', $ARRItem['fastitulo_ch']      ,'0','0','L',1,'');
							pdf_def_lin_text('120' ,'10', $RESGrupoDef['grutitulo_ch']  ,'0','0','L',1,'');
						    pdf_def_lin_text('190' ,'10', $ARRItem['defdescri_ch']  	,'0','0','L',1,'');
						    pdf_def_lin_text('30'  ,'10', $ARRItem['qtddefeito_in'] 	,'0','0','R',1,'');
						    pdf_def_lin_text('50'  ,'10', $INMedCla 				    ,'0','0','R',1,'');
						    pdf_def_lin_text('50'  ,'10', $DCPerDef				   		,'0','1','R',1,'');
		    			}
		    					    			
		    			if ($INTotDef > 0)
		    			{
		    				$DCMedCla = $INTotCla / $INQtdIte;
		    				
		    				pdf_def_break_line(10,1);
							pdf_def_color(225,225,225);
			            	pdf_def_line(30,pdf_get_line() - 5,550,pdf_get_line() -5,'0.5');
		    				
			            	pdf_set_font('Arial','B','8');
			            	
		    				pdf_def_lin_text('150','10', ''  							,'0','0','L',1,'');
						    pdf_def_lin_text('220','10', 'TOTAL (' . $INQtdIte . ')'	,'0','0','R',1,'');
						    pdf_def_lin_text('50' ,'10', format_decimal($INTotDef, "0") ,'0','0','R',1,'');
						    pdf_def_lin_text('50' ,'10', format_decimal($DCMedCla, "2")	,'0','0','R',1,'');
							pdf_def_lin_text('50' ,'10', '100,00'		   				,'0','1','R',1,'');
							
		    			}
		    			else
		    			{
		    				pdf_set_font('Arial','I','8');
		                	pdf_def_color_text('0','0','0');
		                	pdf_def_lin_text('' ,'10','*** Nenhum tipo de defeito encontrado para este tipo de apontamento.','','0','L',1,'');
		                	pdf_def_break_line(10,1);
		    			}
		    			
		    			pdf_def_break_line(10,1);
    				}
    			}
    			elseif ($CMBAgrupador != "0")
    			{

	    			$SQLAgrupado = define_sql("SELECT dbadm.qmsitedoc.itetipo_in,
													  dbind.indproduto.seqmarca_bi, dbadm.admmarca.mardescri_ch,
													  dbadm.qmsitedoc.seqpesso_bi,  dbadm.admpessoa.pesdescri_ch, 
													  dbadm.qmsitedoc.seqfase_bi,   dbind.indfase.fastitulo_ch, 
													  dbadm.qmsitedoc.seqcla_bi,    dbadm.qmsdefeitos.defdescri_ch
										
												 FROM dbadm.qmsdocto, dbsis.sisrelnumuni, dbind.inddocto, dbind.indrefer 
											LEFT JOIN dbind.indproduto ON dbind.indproduto.seqrefer_dc = dbind.indrefer.seqrefer_dc 																		   
										   INNER JOIN dbadm.admmarca   ON dbadm.admmarca.seqmarca_bi = dbind.indproduto.seqmarca_bi $CHWhrMar,
													  dbadm.qmsitedoc, dbadm.admpessoa, dbind.indfase, dbadm.qmsdefeitos

											    WHERE dbadm.qmsdocto.seqempre_bi 	  = $SHempcod 						AND 
													  dbadm.qmsdocto.seqtipba_bi 	  = 35        						AND 
													  dbadm.qmsdocto.seqtipos_bi 	  = 369		  						AND 
													  dbsis.sisrelnumuni.seqempre_dc  = dbadm.qmsdocto.seqempre_bi  	AND 
	                                                  dbsis.sisrelnumuni.seqtipba_dc  = 4 						    	AND 
	                                                  dbsis.sisrelnumuni.seqtipos_dc  = 91 								AND 
	                                                  dbsis.sisrelnumuni.numcodgen_dc = dbadm.qmsdocto.seqdocori_bi 	AND 
													  $CHWhrOps
													  dbind.inddocto.seqdocto_dc	  = dbsis.sisrelnumuni.numcodgen_dc AND 
												      dbind.inddocto.seqtipbas_bi	  = dbsis.sisrelnumuni.seqtipba_dc  AND 
													  dbind.inddocto.seqtipos_dc	  = dbsis.sisrelnumuni.seqtipos_dc  AND
													  $CHWhrDt1
		    										  $CHWhrDt2 
													  $CHWhrRef
													  $CHWhrSts
													  dbind.indrefer.seqrefer_dc      = dbind.inddocto.seqrefer_dc		AND 
													  dbadm.qmsitedoc.seqdocto_bi	  = dbadm.qmsdocto.seqdocto_bi	    AND 
													  $CHWhrPre
	    											  $CHWhrTip
													  dbadm.admpessoa.seqpesso_dc     = dbadm.qmsitedoc.seqpesso_bi	    AND 
													  dbind.indfase.seqfase_dc	      = dbadm.qmsitedoc.seqfase_bi		AND 
													  $CHWhrDef 
													  dbadm.qmsdefeitos.seqdefeito_bi = dbadm.qmsitedoc.seqcla_bi
										     GROUP BY $CMBAgrupador ORDER BY $CMBOrdemGeral");
	    			
    			}
    			else $SQLAgrupado = define_sql("SELECT true");
    			
				if ($SQLAgrupado)
    			{
    				while ($RESAgrupado = $SQLAgrupado->fetch(PDO::FETCH_ASSOC))
    				{    
    					pdf_set_font('Arial','BU','10');
				    	
    					if ($CMBAgrupador == "0") 
    					{
    						$CHWhrAgr = "";
    						pdf_def_lin_text('70','12',"Tipo: Geral" 									 ,'0','1','L','0','');
    					}
    					if ($CMBAgrupador == "dbind.indproduto.seqmarca_bi") 
    					{ 
    						$CHWhrAgr = " AND $CMBAgrupador = {$RESAgrupado['seqmarca_bi']} ";
    						pdf_def_lin_text('70','12',"Marca: {$RESAgrupado['mardescri_ch']}" 			 ,'0','1','L','0','');
    					}
    					if ($CMBAgrupador == "dbadm.qmsitedoc.seqpesso_bi" ) 
    					{
    						$CHWhrAgr = " AND $CMBAgrupador = {$RESAgrupado['seqpesso_bi']} ";
    						pdf_def_lin_text('70','12',"Prestadora: {$RESAgrupado['pesdescri_ch']}" 	 ,'0','1','L','0','');
    					}
	        			if ($CMBAgrupador == "dbadm.qmsitedoc.seqcla_bi"   )
	        			{
	        				$CHWhrAgr = " AND $CMBAgrupador = {$RESAgrupado['seqcla_bi']} ";
	        				pdf_def_lin_text('70','12',"Tipo de defeito: {$RESAgrupado['defdescri_ch']}" ,'0','1','L','0','');
	        			}
	        			if ($CMBAgrupador == "dbadm.qmsitedoc.itetipo_in"  ) 
	        			{
	        				$CHTipoApt = $ARRTipo[$RESAgrupado['itetipo_in']];
	        				
	        				$CHWhrAgr = " AND $CMBAgrupador = {$RESAgrupado['itetipo_in']} ";
	        				pdf_def_lin_text('70','12',"Tipo de apontamento: {$CHTipoApt}" 			     ,'0','1','L','0','');
	        			}
    					
	    				imprimeCabecalho();
	    				
	    				$INTotDef = 0;
    					$DCTotCla = 0;
    					$DCTotPer = 0;
    					$INQtdReg = 0;
    					
						$ARRQtdOps = array();
						$ARRGrupos = array();
	    		
    					$SQLDefeitos = define_sql("SELECT dbsis.sisrelnumuni.numunico_dc, 
														  dbind.inddocto.docstatus_in, 
														  dbadm.qmsitedoc.itetipo_in,
														  dbind.indrefer.refcodigo_ch, 
														  dbind.indrefer.refdescri_ch, 
														  dbadm.admmarca.mardescri_ch,
													 
														 (select SUM(dbind.inditedoc.iteqtde_in) 
															from dbind.inditedoc 
														   where dbind.inditedoc.seqdocto_dc = dbadm.qmsdocto.seqdocori_bi) AS qtdop_in,
		
														  dbadm.admpessoa.pesdescri_ch, 
														  dbind.indfase.fastitulo_ch, 
														  dbadm.qmsdefeitos.seqdefeito_bi, 
														  dbadm.qmsdefeitos.defdescri_ch,
														  dbadm.qmsdefeitos.defclasse_in,														  
														  SUM(dbadm.qmsitedoc.iteqtde_in) iteqtde_in
											
													 FROM dbadm.qmsdocto, dbsis.sisrelnumuni, dbind.inddocto, dbind.indrefer

										 		LEFT JOIN dbind.indproduto 
													   ON dbind.indproduto.seqrefer_dc = dbind.indrefer.seqrefer_dc																		   
											   INNER JOIN dbadm.admmarca
													   ON dbadm.admmarca.seqmarca_bi = dbind.indproduto.seqmarca_bi 
		    											  $CHWhrMar,
		
														  dbadm.qmsitedoc, dbadm.admpessoa, dbind.indfase, dbadm.qmsdefeitos

													WHERE dbadm.qmsdocto.seqempre_bi 	  = $SHempcod 						AND 
														  dbadm.qmsdocto.seqtipba_bi 	  = 35        						AND 
														  dbadm.qmsdocto.seqtipos_bi 	  = 369		  						AND 
														  dbsis.sisrelnumuni.seqempre_dc  = dbadm.qmsdocto.seqempre_bi  	AND 
		                                                  dbsis.sisrelnumuni.seqtipba_dc  = 4 						    	AND 
		                                                  dbsis.sisrelnumuni.seqtipos_dc  = 91 								AND 
		                                                  dbsis.sisrelnumuni.numcodgen_dc = dbadm.qmsdocto.seqdocori_bi 	AND 
														  $CHWhrOps
														  dbind.inddocto.seqdocto_dc	  = dbsis.sisrelnumuni.numcodgen_dc AND 
													      dbind.inddocto.seqtipbas_bi	  = dbsis.sisrelnumuni.seqtipba_dc  AND 
														  dbind.inddocto.seqtipos_dc	  = dbsis.sisrelnumuni.seqtipos_dc  AND
														  $CHWhrDt1
		    											  $CHWhrDt2 
														  $CHWhrRef
														  $CHWhrSts
														  dbind.indrefer.seqrefer_dc      = dbind.inddocto.seqrefer_dc		AND 
														  dbadm.qmsitedoc.seqdocto_bi	  = dbadm.qmsdocto.seqdocto_bi	    AND 
														  $CHWhrPre
		    											  $CHWhrTip
														  dbadm.admpessoa.seqpesso_dc     = dbadm.qmsitedoc.seqpesso_bi	    AND 
														  dbind.indfase.seqfase_dc	      = dbadm.qmsitedoc.seqfase_bi		AND 
														  $CHWhrDef
														  dbadm.qmsdefeitos.seqdefeito_bi = dbadm.qmsitedoc.seqcla_bi		
														  $CHWhrAgr
												 GROUP BY dbsis.sisrelnumuni.numunico_dc, 
														  dbadm.qmsdefeitos.seqdefeito_bi
												 ORDER By $CMBOrdemGeral");
						if ($SQLDefeitos)
		    			{
		    				while ($RESDefeitos = $SQLDefeitos->fetch(PDO::FETCH_ASSOC))
		    				{

								$SQLBusGruDef = define_sql("SELECT dbadm.qmsgrupo.grutitulo_ch,
																   dbadm.qmsgrupo.seqgrupo_in
															  FROM dbadm.qmsreldefgru
														INNER JOIN dbadm.qmsdefeitos
																ON dbadm.qmsdefeitos.seqdefeito_bi = dbadm.qmsreldefgru.seqdefeito_in
														INNER JOIN dbadm.qmsgrupo
																ON dbadm.qmsgrupo.seqgrupo_in = dbadm.qmsreldefgru.seqgrupo_bi
															 WHERE dbadm.qmsreldefgru.seqdefeito_in = {$RESDefeitos['seqdefeito_bi']}");
								$RESGrupoDef = $SQLBusGruDef->fetch(PDO::FETCH_ASSOC);

								$RESDefeitos['grutitulo_ch'] = $RESGrupoDef['grutitulo_ch'];

		    					$ARRQtdOps[$RESDefeitos['numunico_dc']] = $RESDefeitos['qtdop_in'];
								$ARRQtdGer[$RESDefeitos['numunico_dc']] = $RESDefeitos['qtdop_in'];
								
		    					$DCPerDef = round(($RESDefeitos['iteqtde_in'] / $RESDefeitos['qtdop_in']) * 100,2);
		    					
		    					$INTotDef += $RESDefeitos['iteqtde_in'];
		    					$DCTotCla += $RESDefeitos['defclasse_in'];
		    					$DCTotPer += $DCPerDef;
		    					$INQtdReg++;
								
								$ARRGrupos[$RESGrupoDef['seqgrupo_in']]['desc']  = $RESGrupoDef['grutitulo_ch'];
								$ARRGrupos[$RESGrupoDef['seqgrupo_in']]['qtde'] += $RESDefeitos['iteqtde_in'];
								$ARRDefeitos[$RESGrupoDef['seqgrupo_in']][$RESDefeitos['seqdefeito_bi']]['desc']  = $RESDefeitos['defdescri_ch'];
								$ARRDefeitos[$RESGrupoDef['seqgrupo_in']][$RESDefeitos['seqdefeito_bi']]['qtde'] += $RESDefeitos['iteqtde_in'];

		    					$INGerDef += $RESDefeitos['iteqtde_in'];
				    			$DCGerCla += $RESDefeitos['defclasse_in'];
				    			$DCGerPer += $DCPerDef;
				    			$INGerReg++;

				    			$RESDefeitos['desstatus_ch'] = FUNretornatipo($RESDefeitos['docstatus_in']);
		    					$RESDefeitos['refdesdet_ch'] = $RESDefeitos['refcodigo_ch'] . " - " . $RESDefeitos['refdescri_ch'];
		    					$RESDefeitos['qtdpecops_in'] = format_decimal($RESDefeitos['qtdop_in'], 0);
		    					$RESDefeitos['tipoapont_ch'] = $ARRTipo[$RESDefeitos['itetipo_in']];
		    					$RESDefeitos['qtdpecdef_in'] = format_decimal($RESDefeitos['iteqtde_in'], 0);
		    					$RESDefeitos['qtdperdef_in'] = format_decimal($DCPerDef, 2);
		    					
		    					$RESDefeitos['refdesdet_ch'] = strlen($RESDefeitos['refdesdet_ch']) > 25          ? 
		    												   substr($RESDefeitos['refdesdet_ch'],0, 23) . "..." : 
		    												   $RESDefeitos['refdesdet_ch'];
		    					
								$RESDefeitos['mardescri_ch'] = strlen($RESDefeitos['mardescri_ch']) > 19          ? 
		    												   substr($RESDefeitos['mardescri_ch'],0, 16) . "..." : 
		    												   $RESDefeitos['mardescri_ch'];
								
								$RESDefeitos['pesdescri_ch'] = strlen($RESDefeitos['pesdescri_ch']) > 17          ? 
		    												   substr($RESDefeitos['pesdescri_ch'],0, 15) . "..." : 
		    												   $RESDefeitos['pesdescri_ch'];
								
								$RESDefeitos['fastitulo_ch'] = strlen($RESDefeitos['fastitulo_ch']) > 12          ? 
		    												   substr($RESDefeitos['fastitulo_ch'],0, 9) . "..." : 
		    												   $RESDefeitos['fastitulo_ch'];
								
								$RESDefeitos['defdescri_ch'] = strlen($RESDefeitos['defdescri_ch']) > 35          ? 
		    												   substr($RESDefeitos['defdescri_ch'],0, 32) . "..." : 
															   $RESDefeitos['defdescri_ch']; 
															   
								$RESDefeitos['grutitulo_ch'] = strlen($RESDefeitos['grutitulo_ch'])> 30 		  ? 
															   substr($RESDefeitos['grutitulo_ch'],0, 27) . "..." : 
															   $RESDefeitos['grutitulo_ch']; 
		    					
		    					pdf_def_lin_text('35' ,'10', $RESDefeitos['numunico_dc' ] ,'0','0','R',0,'');
					    		pdf_def_lin_text('35' ,'10', $RESDefeitos['desstatus_ch'] ,'0','0','L',0,'');
					    		pdf_def_lin_text('100','10', $RESDefeitos['refdesdet_ch'] ,'0','0','L',1,'');
					    		pdf_def_lin_text('70' ,'10', $RESDefeitos['mardescri_ch'] ,'0','0','L',0,'');
					    		pdf_def_lin_text('35' ,'10', $RESDefeitos['qtdpecops_in'] ,'0','0','R',0,'');
					    		pdf_def_lin_text('40' ,'10', $RESDefeitos['tipoapont_ch'] ,'0','0','L',0,'');
					    		pdf_def_lin_text('85' ,'10', $RESDefeitos['pesdescri_ch'] ,'0','0','L',0,'');
					    		pdf_def_lin_text('50' ,'10', $RESDefeitos['fastitulo_ch'] ,'0','0','L',0,'');
								pdf_def_lin_text('125','10', $RESDefeitos['defdescri_ch'] ,'0','0','L',0,'');
								pdf_def_lin_text('115','10', $RESDefeitos['grutitulo_ch'] ,'0','0','L',0,'');
					    		pdf_def_lin_text('30' ,'10', $RESDefeitos['qtdpecdef_in'] ,'0','0','R',0,'');
					    		pdf_def_lin_text('30' ,'10', $RESDefeitos['defclasse_in'] ,'0','0','R',0,'');
								pdf_def_lin_text('35' ,'10', $RESDefeitos['qtdperdef_in'] ,'0','1','R',0,'');

							}
						}
		    			if ($INQtdReg > 0)
		    			{
		    				pdf_def_break_line(10,1);
		                	pdf_def_color(225,225,225);
		                	pdf_def_line(40,pdf_get_line() - 5,815,pdf_get_line() -5,'0.5');
		                	
		                	$DCMedCla = $DCTotCla / $INQtdReg;
		                	$DCMedPer = $DCTotPer / $INQtdReg;
		                			                	
		                	$INQtdPec = 0;
		                	$INQtdOps = sizeof($ARRQtdOps);
		                	foreach($ARRQtdOps as $key=>$value)
							{
								$INQtdPec += $value;
							}
							
							if ($CMBAgrupador != "0") 
    							 $CHTextoTotal = "Resumo do agrupador => ";
							else $CHTextoTotal = "Resumo total => ";

							$CHtotOP = $INQtdOps . " OP(s) com " . format_decimal($INQtdPec, "0") . " peça(s)";
		                	
							pdf_set_font('Arial','B','8');
							
		                	pdf_def_lin_text('35' ,'10', '' 							,'0','0','R',0,'');
					    	pdf_def_lin_text('45' ,'10', '' 							,'0','0','L',0,'');
					    	pdf_def_lin_text('145','10', '' 							,'0','0','L',0,'');
					    	pdf_def_lin_text('70' ,'10', '' 							,'0','0','L',0,'');
					    	pdf_def_lin_text('35' ,'10', '' 							,'0','0','R',0,'');
					    	pdf_def_lin_text('40' ,'10', '' 							,'0','0','L',0,'');
					    	pdf_def_lin_text('145','10', '' 							,'0','0','L',0,'');
					    	pdf_def_lin_text('50' ,'10', $CHTextoTotal					,'0','0','R',0,'');
					    	pdf_def_lin_text('125','10', $CHtotOP						,'0','0','R',0,'');
					    	pdf_def_lin_text('30' ,'10', format_decimal($INTotDef, "0") ,'0','0','R',0,'');
					    	pdf_def_lin_text('30' ,'10', format_decimal($DCMedCla, "2") ,'0','0','R',0,'');
							pdf_def_lin_text('35' ,'10', format_decimal($DCMedPer, "2") ,'0','1','R',0,'');
		    			}
		    			else
		    			{
		    				pdf_set_color_background(255,255,255);
	    					pdf_def_color_text(0,0,0);
		    				pdf_set_font('Arial','I','8');
		                	pdf_def_color_text('0','0','0');
		                	pdf_def_lin_text('' ,'10','*** Nenhum tipo de defeito encontrado com este critério.','','0','L',1,'');
		    			}
    				}
    				
    				if ($CMBAgrupador != "0") 
    				{
	    				if ($INGerReg > 0)
			    		{		    			
			    			pdf_def_break_line(10,1);
			                pdf_def_color(225,225,225);
			                pdf_def_line(40,pdf_get_line() - 5,815,pdf_get_line() -5,'0.5');
			                	
			                $DCMedCla = $DCGerCla / $INGerReg;
			                $DCMedPer = $DCGerPer / $INGerReg;
			                
			                $INQtdTot = 0;
			                $INQtdOps = sizeof($ARRQtdGer);
			    			foreach($ARRQtdGer as $key=>$value)
							{
								$INQtdTot += $value;
							}
							
							$CHTextoTotal = $INQtdOps . " OP(s) com " . format_decimal($INQtdTot, "0") . " peça(s)";
			                
							pdf_set_font('Arial','B','8');
							
			                pdf_def_lin_text('35' ,'10', '' 							,'0','0','R',0,'');
						    pdf_def_lin_text('45' ,'10', '' 							,'0','0','L',0,'');
						    pdf_def_lin_text('145','10', '' 							,'0','0','L',0,'');
						    pdf_def_lin_text('70' ,'10', '' 							,'0','0','L',0,'');
						    pdf_def_lin_text('35' ,'10', '' 							,'0','0','R',0,'');
						    pdf_def_lin_text('40' ,'10', '' 							,'0','0','L',0,'');
						    pdf_def_lin_text('145','10', '' 							,'0','0','L',0,'');
						    pdf_def_lin_text('50' ,'10', 'Resumo total => '				,'0','0','R',0,'');
						    pdf_def_lin_text('125','10', $CHTextoTotal					,'0','0','R',0,'');
						    pdf_def_lin_text('30' ,'10', format_decimal($INGerDef, "0") ,'0','0','R',0,'');
						    pdf_def_lin_text('30' ,'10', format_decimal($DCMedCla, "2") ,'0','0','R',0,'');
							pdf_def_lin_text('35' ,'10', format_decimal($DCMedPer, "2") ,'0','1','R',0,'');		
														
			    		}
    					else
		    			{		    				
		    				imprimeCabecalho();
		    				
		    				pdf_set_font('Arial','I','8');
		                	pdf_def_color_text('0','0','0');
		                	pdf_def_lin_text('' ,'10','*** Nenhum tipo de defeito encontrado com este critério.','','0','L',1,'');
		    			}
    				}    				
				}

				if($CHKDefeitos == 1)
				{
					pdf_def_break_line(10,1);
					 
					uasort($ARRGrupos,function($a,$b){

						if($a['qtde'] == $b['qtde']) {
							return 0;
						}
						return ($a['qtde'] > $b['qtde']) ? -1 : 1;						
					});

					pdf_def_color(225,225,225);
					pdf_set_color_background(155,155,155);
					pdf_def_color_text('255','255','255');
					pdf_set_font('Arial','','8');

					pdf_set_font('Arial','B','8');
					pdf_def_lin_text('235' ,'12', "Total de Defeitos" 							,'1','0','L',1,'');
					pdf_def_lin_text('30' ,'12' , $INGerDef 									,'1','0','R',1,'');
					pdf_def_lin_text('50' ,'12' , '100%'	 									,'1','1','R',1,'');

					pdf_def_color(225,225,225);
					pdf_set_color_background(155,155,155);
					pdf_def_color_text('0','0','0');
					pdf_set_font('Arial','','8');
					
					foreach($ARRGrupos as $key => $value)
					{
						$DCPorGru = abs((($INGerDef - $value['qtde']) / $INGerDef) * 100 - 100);

						pdf_set_font('Arial','B','8');
						pdf_def_lin_text('235' ,'12', $value['desc'] 							,'1','0','L',0,'');
						pdf_def_lin_text('30' ,'12' , $value['qtde'] 							,'1','0','R',0,'');
						pdf_def_lin_text('50' ,'12' , format_decimal($DCPorGru,'1').'%' 		,'1','1','R',0,'');

						foreach($ARRDefeitos[$key] as $key2 => $value2)
						{
							$DCPorDef = abs((($value['qtde'] - $value2['qtde']) / $value['qtde']) * 100 - 100);

							pdf_set_font('Arial','','8');
							pdf_def_lin_text('235' ,'12', $value2['desc'] 						,'1','0','L',0,'');
							pdf_def_lin_text('30'  ,'12', $value2['qtde'] 						,'1','0','R',0,'');
							pdf_def_lin_text('50' ,'12' , format_decimal($DCPorDef,'1').'%'		,'1','1','R',0,'');
							
						}
					}
				}

			return_data (close_link_pdf("",false));
		}
		elseif ($FRWAction == "CMBMARCA")
	    {
	        $CHSQLMarca = define_sql("SELECT dbadm.admmarca.seqmarca_bi, dbadm.admmarca.mardescri_ch
									    FROM dbadm.admmarca, dbadm.admpessoa
									   WHERE dbadm.admpessoa.seqempre_dc = '$SHempcod' AND
									         dbadm.admpessoa.seqpesso_dc =  dbadm.admmarca.seqpesso_bi
									ORDER BY dbadm.admmarca.mardescri_ch");
	        if ($CHSQLMarca)
	        {
	            while ($RESMarca = $CHSQLMarca->fetch(PDO::FETCH_ASSOC))
	            {
	                set_option_combo($RESMarca['seqmarca_bi'] , $RESMarca['mardescri_ch']);
	            }
	        }
	    }    
	    elseif ($FRWAction == "CMBGRUPO")
	    {
	    	
	    	$CHSqlGrupo = define_sql("SELECT dbadm.qmsgrupo.seqgrupo_in, dbadm.qmsgrupo.grutitulo_ch		        									 
										FROM dbadm.qmsgrupo
		        					   WHERE dbadm.qmsgrupo.seqgrupo_in != 0
									ORDER BY dbadm.qmsgrupo.seqgrupo_in");
	        if($CHSqlGrupo)
	        {
	            while($RESGrupo = $CHSqlGrupo->fetch(PDO::FETCH_ASSOC))
	            {
	                set_option_combo($RESGrupo['seqgrupo_in'],$RESGrupo['grutitulo_ch']);                
	        	}
	    	}         
	    }
	close_db();
	
	function FUNBuscaQuantidades($BISeqOps)
    {
    	$INQtdeDef = 0;
    	$INQtdePer = 0;
    	$INQtdeRem = 0;
    	$INQtdePro = 0;
    	$INProTot  = 0;
    	$INQtdeOri = 0;
    	$INQtdeMps = 0;
    	$INQtdeAju = 0;
    	
    	$SQLBusFas = define_sql("SELECT dbind.inddocto.docdatpri_dt,
										dbind.inddocto.docdatprf_dt,
										dbind.inddocto.docdatrei_dt,
										dbind.inddocto.docdatref_dt,
										dbind.inddocto.seqdocto_dc,
										dbind.inddocto.seqfase_bi
								   FROM dbind.inddocto
								  WHERE dbind.inddocto.seqtipbas_bi = 4				AND 
										dbind.inddocto.seqtipos_dc  = 103			AND 
										dbind.inddocto.seqdocori_bi = $BISeqOps 	
							   GROUP BY dbind.inddocto.seqfase_bi
		                       ORDER BY dbind.inddocto.fasordem_in");
		if($SQLBusFas)
		{
			while($RESBusFas = $SQLBusFas->fetch(PDO::FETCH_ASSOC))
			{
				$ARRPecas = FUNSaldoFase($BISeqOps, $RESBusFas['seqfase_bi']);
					 
				$INQtdeRem += $ARRPecas['INDigRem'] + $ARRPecas['INQtdRem'];
				$INQtdePer += $ARRPecas['INDigPer'] + $ARRPecas['INQtdPer'];
				
				if($INQtdeMps == 0)
				{
					$INQtdeMps += $ARRPecas['INQtdDis'];
				}
			}
		}
		
		$INQtdeDef = $ARRPecas['INDigDef'] + $ARRPecas['INQtdDef'];
		$INQtdePro = $ARRPecas['INQtdEnt'] + $ARRPecas['INQtdPro'];
		
		$SQLOriDoc = define_sql("SELECT SUM(dbind.inditedoc.iteqtde_in) AS iteqtde_in
								   FROM dbind.inditedoc
								  WHERE dbind.inditedoc.seqdocto_dc = '$BISeqOps'");
		$RESOriDoc = $SQLOriDoc->fetch(PDO::FETCH_ASSOC);
		$INQtdeOri = $RESOriDoc['iteqtde_in'];
		
		$INProTot  = $INQtdePro + $INQtdeDef;
		$INQtdeAju = $INQtdeOri - $INQtdeMps;
                        
        $ARRQtdeOP['INQtdeOri'] = $INQtdeOri;
        $ARRQtdeOP['INQtdePro'] = $INQtdePro;
        $ARRQtdeOP['INQtdeDef'] = $INQtdeDef;
        $ARRQtdeOP['INQtdePer'] = $INQtdePer;
        $ARRQtdeOP['INQtdeRem'] = $INQtdeRem;
        $ARRQtdeOP['INQtdeMps'] = $INQtdeMps;
        $ARRQtdeOP['INQtdeAju'] = $INQtdeAju;
        $ARRQtdeOP['INProTot']  = $INProTot;
        
        return $ARRQtdeOP;
    }
	
    //Consulta de quantidades erradas, aumenta qtde de acordo com a quantidade de partes/distr para mesma fase 
	function FUNBuscaQuantidadesOLD($BISeqOps)
    {
    	$INQtdeDef = 0;
    	$INQtdePer = 0;
    	$INQtdeRem = 0;
    	$INQtdePro = 0;
    	$INProTot  = 0;
    	$INQtdeOri = 0;
    	$INQtdeMps = 0;
    	$INQtdeAju = 0;
    	
   		$SQLBusQtde = define_sql("SELECT SUM(dbind.inditedoc.iteqtde_in) AS iteqted_in 
   								    FROM dbind.inddocto FASE, 
   										 dbind.inditedoc 
   								   WHERE FASE.seqdocori_bi  		  = $BISeqOps 		 AND 
   										 FASE.fasordem_in   		  = 1		  		 AND 
   										 dbind.inditedoc.seqdocto_dc  = FASE.seqdocto_dc AND 
   										 dbind.inditedoc.itetipmov_in = 0 "); 
   		$RESBusQtde = $SQLBusQtde->fetch(PDO::FETCH_ASSOC);  
   		$INQtdeMps  = $RESBusQtde['iteqted_in']; 
    	 
		$SQLUltFas = define_sql("SELECT dbind.inddocto.seqdocto_dc  
		                 		   FROM dbind.inddocto 
		                		  WHERE dbind.inddocto.seqdocori_bi = '$BISeqOps'    AND 
		                				dbind.inddocto.seqtipbas_bi = 4              AND
		                				dbind.inddocto.seqtipos_dc  = 103
		                	   ORDER BY dbind.inddocto.fasordem_in DESC LIMIT 1");
		$RESFalUlt = $SQLUltFas->fetch(PDO::FETCH_ASSOC);
		$BIFasUlt  = $RESFalUlt['seqdocto_dc'];
		                
		// Busca as exeções nas fases produtivas
        $SQLBusFas = define_sql("SELECT dbind.inditedoc.itetipmov_in, 
        								dbind.inditedoc.iteqtde_in
         						   FROM dbind.inddocto, dbind.inditedoc
                                  WHERE dbind.inddocto.seqdocori_bi   = '$BISeqOps' 			    AND
                          			    dbind.inddocto.seqtipbas_bi   = 4         			    	AND  
                                        dbind.inddocto.seqtipos_dc    = 103         			    AND 
                          				dbind.inditedoc.itestatus_in  = 1							AND 
                                        dbind.inditedoc.seqdocto_dc   = dbind.inddocto.seqdocto_dc  AND 
                           				dbind.inditedoc.itetipmov_in IN (3,4,5)					 ");
        if ($SQLBusFas)
        {
        	while ($RESQtdeFas = $SQLBusFas->fetch(PDO::FETCH_ASSOC))
            {
            	if ($RESQtdeFas['itetipmov_in'] == 3) $INQtdeRem += $RESQtdeFas['iteqtde_in'];
                if ($RESQtdeFas['itetipmov_in'] == 4) $INQtdePer += $RESQtdeFas['iteqtde_in'];
                if ($RESQtdeFas['itetipmov_in'] == 5) $INQtdeDef += $RESQtdeFas['iteqtde_in'];
            }
        }
                                
        $SQLOriDoc = define_sql("SELECT SUM(dbind.inditedoc.iteqtde_in) AS iteqtde_in
          						   FROM dbind.inditedoc
           						  WHERE dbind.inditedoc.seqdocto_dc = '$BISeqOps'");
        $RESOriDoc = $SQLOriDoc->fetch(PDO::FETCH_ASSOC);
        $INQtdeOri = $RESOriDoc['iteqtde_in'];
                        
        // Busca quantidade produzida da OP
        $SQLQtdePro = define_sql("SELECT SUM(dbind.inditedoc.iteqtde_in) AS iteqtde_in 
           							 FROM dbind.inditedoc
           						    WHERE dbind.inditedoc.seqdocto_dc   = '$BIFasUlt' 		AND 
           								  dbind.inditedoc.itetipmov_in  = 1 				AND 
                   						  dbind.inditedoc.itestatus_in  = 1	");
        $RESQtdePro = $SQLQtdePro->fetch(PDO::FETCH_ASSOC);
        $INQtdePro  = $RESQtdePro['iteqtde_in'];
        
        $INProTot  = $INQtdePro + $INQtdeDef;
        $INQtdeAju = $INQtdeOri - $INQtdeMps;
        
        //Para as OPS do controle de produção antigo
        if($INQtdeOri == 0) $INQtdeOri = $INQtdePro + $INQtdeDef + $INQtdePer + $INQtdeRem;
                        
        $ARRQtdeOP['INQtdeOri'] = $INQtdeOri;
        $ARRQtdeOP['INQtdePro'] = $INQtdePro;
        $ARRQtdeOP['INQtdeDef'] = $INQtdeDef;
        $ARRQtdeOP['INQtdePer'] = $INQtdePer;
        $ARRQtdeOP['INQtdeRem'] = $INQtdeRem;
        $ARRQtdeOP['INQtdeMps'] = $INQtdeMps;
        $ARRQtdeOP['INQtdeAju'] = $INQtdeAju;
        $ARRQtdeOP['INProTot']  = $INProTot;
        
        return $ARRQtdeOP;
    }
	
	function imprimeCabecalho()
	{
		pdf_def_color(225,225,225);
		pdf_set_color_background(155,155,155);
	    pdf_def_color_text('255','255','255');
	    pdf_set_font('Arial','','7');
	    														
	    pdf_def_lin_text('35' ,'10','OP N°'   			,'1','0','R',1,'');
	    pdf_def_lin_text('35' ,'10','Situação'   		,'1','0','L',1,'');
	    pdf_def_lin_text('100','10','Referência'		,'1','0','L',1,'');
	    pdf_def_lin_text('70' ,'10','Marca'		   		,'1','0','L',1,'');
	    pdf_def_lin_text('35' ,'10','Qtde OP' 			,'1','0','R',1,'');
	    pdf_def_lin_text('40' ,'10','Tipo'		 		,'1','0','L',1,'');
	    pdf_def_lin_text('85','10','Prestador'			,'1','0','L',1,'');
	    pdf_def_lin_text('50' ,'10','Fase'				,'1','0','L',1,'');
		pdf_def_lin_text('125','10','Defeito'			,'1','0','L',1,'');
		pdf_def_lin_text('115' ,'10','Grupo'			,'1','0','L',1,'');
	    pdf_def_lin_text('30' ,'10','Peças'				,'1','0','R',1,'');
	    pdf_def_lin_text('30' ,'10','Class.'		  	,'1','0','R',1,'');
	    pdf_def_lin_text('35' ,'10','% da OP'			,'1','1','R',1,'');
    								
    	pdf_set_color_background(255,255,255);
    	pdf_def_color_text('0','0','0');
	}
	
	function imprimeCabecalhoResumido()
	{
		pdf_def_color(225,225,225);
		pdf_set_color_background(155,155,155);
	    pdf_def_color_text('255','255','255');
	    pdf_set_font('Arial','','7');
	    														
		pdf_def_lin_text('80','10','Fase'				,'1','0','L',1,'');
		pdf_def_lin_text('120','10','Grupo Defeito'		,'1','0','L',1,'');
	    pdf_def_lin_text('190','10','Defeito'			,'1','0','L',1,'');
	    pdf_def_lin_text('30' ,'10','Peças'				,'1','0','R',1,'');
	    pdf_def_lin_text('50' ,'10','Média class.'	  	,'1','0','R',1,'');
	    pdf_def_lin_text('50' ,'10','% do Total'		,'1','1','R',1,'');
    								
    	pdf_set_color_background(255,255,255);
    	pdf_def_color_text('0','0','0');
	}
	
	function comBG()
	{
		pdf_def_color(225,225,225);
		pdf_set_color_background(155,155,155);
	    pdf_def_color_text('255','255','255');
	    pdf_set_font('Arial','B','8');
	}
	
	function semBG()
	{
		pdf_def_color(225,225,225);
		pdf_set_color_background(255,255,255);
	    pdf_def_color_text(0,0,0);
	    pdf_set_font('Arial','','8');
	}
?>

    
