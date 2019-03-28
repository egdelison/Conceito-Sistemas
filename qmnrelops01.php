<?php
	/*----------------------------------------------------------------------------*/
	/* Programa: qmirelops01.php                                   				  */
	/* Tipo....: HTML  (Html ou Flex)                                             */                         
	/* Função..: Gerar relatório de qualidade por OP detalhado     			  	  */
	/* Data....: 22/11/2018                                            		      */
	/* Autor...: Elison Goulart Duarte                                 			  */
	/* Sistema.: (QMS - Relatórios)                        			              */
	/* Processo: Gerar relatório de qualidade por OP detalhado     			  	  */
	/* Revisões: Data       Autor          Observação                   Versão    */
	/*----------------------------------------------------------------------------*/
	/*			21/01/2019 Daniel Mezzari  - Ajustes nos filtros				  */
	/*----------------------------------------------------------------------------*/

    include('sinproweb01.php');
    include('sinprogen01.php');
    include('siirelfil01.php');
    
    // Variaveis para tradução
    $TBL = "";
    $BTN = "";
    $MSG = "GERREL";
    $TXT = "TODAS,TODOS,REFER,LOG,MARCA,COLE,DATAINI,DATAFIM,SITU,FASE,TIPO,SOMEN,IMPRIMIR,PRES,NAOCONFORMIDADE";

    // Seta a tradução conforme variáveis acima
    set_translate($TBL,$BTN,$MSG,$TXT);
    
    open_screen(trim($CHFRWmenutit), $CHFRWmenutip);
    
    	define_var_html("CHArqrel", "");
    	define_var_html("CHSitSel", "");
    	define_var_html("CHMarSel", "");
    	define_var_html("CHTipSel", "");
    
    	set_load_prg("EMPTY", "Iniciar");
        
	    set_width ('780px');
		set_height('303px');
	    set_position("70,3");
	    open_box(); close_box();
	    
	    define_lbl_field('70', 'OP nº'                   , 'INCodOps', '68'  , 'I15', '75,125');

	    open_lbl_MultiCombo('80', 'Situação OP'			 , 'CMBSitOps', '150', '75,360');
	        set_combo("Aberta"       , "73");
	        set_combo("Encerrada"    , "76");        
	    close_lbl_MultiCombo();
	    
	    open_lbl_MultiCombo('70', 'Marca'                , 'CMBMarca', '395', '95,125','', 0, 140);
			set_load_combo("qmnrelops01.php"             , "CMBMarca", "MARCA", true);
	    close_lbl_MultiCombo();   
	    
	    define_filtro_refer   ('BISeqRef', '26' 		 , get_translate_text("#REFER"), '395,70', '115,130');
	    define_filtro_pesso2  ('BISeqPre', '17' 		 , get_translate_text("#PRES") , '395,70', '186,129');
	    define_filtro_defeitos("BISeqDef"		    	 , "Tipos de defeitos"		   , '395,70', '257,96');    
	    
	    open_lbl_MultiCombo('130', 'Tipo de apontamento'    , 'CMBTipoDef', '190', '330,65','', 0);
			set_combo('Defeito (LD)','5');
	        set_combo('Perda'       ,'4');
	        set_combo('Remonte'     ,'3');
	    close_lbl_MultiCombo();
	    
	    open_lbl_combo('70', 'Formato', 'CMBAgrupador', '100', '330,420','', 0);	    	
			set_combo('Geral'					,'0');
			set_combo('Resumido'				,'R');
	        set_combo('Por marca'       		,'dbind.indproduto.seqmarca_bi');
	        set_combo('Por prestadora'     	    ,'dbadm.qmsitedoc.seqpesso_bi');
	        set_combo('Por tipo de defeito'     ,'dbadm.qmsitedoc.seqcla_bi');
	        set_combo('Por tipo de apontamento' ,'dbadm.qmsitedoc.itetipo_in');
		close_combo();
		
		define_lbl_check("145", "Imprimir totais de defeitos", "CHKDefeitos", "330,605", "destaque");
	    
	    set_width ('780px');
	    set_height('35px');
	    set_position("375,3");
	    open_box(); close_box();
	    
	    set_validate("É necessário informar a data inicial da OP.");
	    define_lbl_field('90', 'Data da OP', 'DTIni', '68' , 'DATE', '383,105');
	    set_validate("É necessário informar a data final da OP.");
		define_lbl_field('30', 'Até'       , 'DTFim', '68' , 'DATE', '383,295');
		
		open_lbl_combo('70', 'Ordenar', 'CMBOrdemGeral', '100', '383,420','', 0);	    	
			set_combo('Por OP'     	    	,'dbsis.sisrelnumuni.numunico_dc');
			set_combo('Por classificação' 	,'dbadm.qmsdefeitos.defclasse_in');
			set_combo('Por defeito' 		,'dbadm.qmsdefeitos.defdescri_ch');
			set_combo('Por fase' 			,'dbind.indfase.fastitulo_ch');
			set_combo('Por marca' 			,'dbadm.admmarca.mardescri_ch');
			set_combo('Por prestadora' 		,'dbadm.admpessoa.pesdescri_ch');
			set_combo('Por qtde de peças' 	,'iteqtde_in');
			set_combo('Por referência'     	,'dbind.indrefer.refdescri_ch');
		close_combo();

		open_lbl_combo('70', 'Ordenar'  , 'CMBOrdemResum', '100', '383,420','', 0);	    	
			set_combo('Por fase' 			,'dbind.indfase.fastitulo_ch');
			set_combo('Por defeito' 		,'dbadm.qmsdefeitos.defdescri_ch');
			set_combo('Por qtde de peças' 	,'qtddefeito_in');
		close_combo();

	    define_lbl_check("100", "Imprimir filtros", "CHKFiltros", "383,620", "destaque");
	    
	    open_filter('780','412,3');
			$CHcampos = "INCodOps,CMBSitOps,CMBMarca,EDTBISeqRef,EDTBISeqPre,EDTBISeqDef,CMBTipoDef,DTIni,DTFim,CMBOrdemGeral,CMBOrdemResum,CHKFiltros,CHKDefeitos";
			set_fields_filter($CHcampos);
	    close_filter();
	    
	    set_width('780px');
	    set_valign('top');
	    set_position("456,3");
	    open_box();    
	        define_warning();
	    close_box(); 
	    
	    //==================================================//
	    //                      EVENTOS                     //
	    //==================================================//
	    
	    open_event("EMPTY", "Iniciar");
	        set_sensitive("true", "INCodOps,CMBMarca,CMBSitOps,CMBTipoDef,CMBAgrupador,DTIni,DTFim,CHKFiltros,CHKDefeitos,CMBOrdemGeral");
			set_visibility('CMBOrdemGeral', true);
			set_visibility('CMBOrdemResum', false);
			set_visibility('LBLCMBOrdemGeral', true);
			set_visibility('LBLCMBOrdemResum', false);
			
	        set_value(date("01/m/Y"),"DTIni");
        	set_value(today(),"DTFim");
		close_event();
		
		open_event('ONCHANGED', 'CMBAgrupador');
			if_eq_field('CMBAgrupador','R',true);
				set_visibility('CMBOrdemResum', true);
				set_visibility('CMBOrdemGeral', false);
				set_visibility('LBLCMBOrdemResum', true);
				set_visibility('LBLCMBOrdemGeral', false);
				set_sensitive('true', 'CMBOrdemResum');
			else_if();
				set_visibility('CMBOrdemGeral', true);
				set_visibility('CMBOrdemResum', false);
				set_visibility('LBLCMBOrdemGeral', true);
				set_visibility('LBLCMBOrdemResum', false);
				set_sensitive('true', 'CMBOrdemGeral');
			end_if();
		close_event();
	    
	    open_event("ONMOUSECLICK", "BTNlistar");
	    	start_validate();
	    
	        set_warning("#GERREL", false, true);//Mensagem de carregando
	        
	        get_text_combo("CMBSitOps" , "CHSitSel");
	        get_text_combo("CMBMarca"  , "CHMarSel");
	        get_text_combo("CMBTipoDef", "CHTipSel");
	        
	        event_aux("EMPTY","AbrirRelatorio");
	        get_data_db('qmnrelops01.php','CHArqrel','RELATORIO',$CHcampos . ",BISeqRef,BISeqPre,BISeqDef,CMBAgrupador,CHSitSel,CHMarSel,CHTipSel");
	    close_event();
	    
	    open_event("EMPTY", "AbrirRelatorio");
	    	hide_process();
        	set_warning("");
        	set_popup("CHArqrel",'0','0', true);
	    close_event();
	    
	close_screen();
?>   
