/*
####################################################################################
### ADD CUSTOM BUTTON TO WORDPRESS TINYMCE EDITOR - 'INSERT 3 COLUMNS' SHORTCODE ###
####################################################################################
*/
(function() {
	tinymce.PluginManager.add('tinymce_precise_columns_button', function(editor, url) {
		editor.addButton('tinymce_precise_columns_button', {
			title: 'Precise Columns',
			type: 'menubutton',
			icon: 'icon pc_tinymce_icon',
			// ### DROPDOWN MENU THAT IS DISPLAYED WHEN TINYMCE BUTTON IS CLICKED ###
			menu: [
				{
					// ###########################
					// ### 2 COLUMNS MENU ITEM ###
					// ###########################
					text: '2 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '2 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '767' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap2', label: '- Gap for 2 Column mode', value: '5' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '8' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[col2";
								if (e.data.break1 != '') {
									out += " break='" + e.data.break1 + "'";
								}
								if ((e.data.gap2 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap2 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[/col2]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 2 COLUMNS MENU ITEM ###
				},
				
				{
					// ###########################
					// ### 3 COLUMNS MENU ITEM ###
					// ###########################
					text: '3 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '3 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break2', label: '- Switch to 2&1 Column mode at', value: '959' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '767' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap3', label: '- Gap for 3 Column mode', value: '4' },
								{ type: 'textbox', name: 'gap2', label: '- Gap for 2&1 Column mode', value: '6' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '8' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[col3";
								if ((e.data.break2 != '') && (e.data.break1 != '')) {
									out += " break='" + e.data.break2 + "," + e.data.break1 + "'";
								}
								if ((e.data.gap3 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap3 + "," + e.data.gap2 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[col]COLUMN 3 CONTENT[/col]";
								out += "[/col3]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 3 COLUMNS MENU ITEM ###
				},
				
				{
					// ###########################
					// ### 4 COLUMNS MENU ITEM ###
					// ###########################
					text: '4 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '4 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break2', label: '- Switch to 2 Column mode at', value: '959' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '479' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap4', label: '- Gap for 4 Column mode', value: '3' },
								{ type: 'textbox', name: 'gap2', label: '- Gap for 2 Column mode', value: '5' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '8' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[col4";
								if ((e.data.break2 != '') && (e.data.break1 != '')) {
									out += " break='" + e.data.break2 + "," + e.data.break1 + "'";
								}
								if ((e.data.gap4 != '') && (e.data.gap2 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap4 + "," + e.data.gap2 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[col]COLUMN 3 CONTENT[/col]";
								out += "[col]COLUMN 4 CONTENT[/col]";
								out += "[/col4]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 4 COLUMNS MENU ITEM ###
				},
				
				{
					// ###########################
					// ### 5 COLUMNS MENU ITEM ###
					// ###########################
					text: '5 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '5 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break3', label: '- Switch to 3&2 Column mode at', value: '959' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '479' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap5', label: '- Gap for 5 Column mode', value: '2' },
								{ type: 'textbox', name: 'gap3', label: '- Gap for 3&2 Column mode', value: '4' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '6' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[col5";
								if ((e.data.break3 != '') && (e.data.break1 != '')) {
									out += " break='" + e.data.break3 + "," + e.data.break1 + "'";
								}
								if ((e.data.gap6 != '') && (e.data.gap3 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap5 + "," + e.data.gap3 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[col]COLUMN 3 CONTENT[/col]";
								out += "[col]COLUMN 4 CONTENT[/col]";
								out += "[col]COLUMN 5 CONTENT[/col]";
								out += "[/col5]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 5 COLUMNS MENU ITEM ###
				},
				
				{
					// ###########################
					// ### 6 COLUMNS MENU ITEM ###
					// ###########################
					text: '6 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '6 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break3', label: '- Switch to 3 Column mode at', value: '959' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '479' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap6', label: '- Gap for 6 Column mode', value: '2' },
								{ type: 'textbox', name: 'gap3', label: '- Gap for 3 Column mode', value: '4' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '6' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[col6";
								if ((e.data.break3 != '') && (e.data.break1 != '')) {
									out += " break='" + e.data.break3 + "," + e.data.break1 + "'";
								}
								if ((e.data.gap6 != '') && (e.data.gap3 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap6 + "," + e.data.gap3 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[col]COLUMN 3 CONTENT[/col]";
								out += "[col]COLUMN 4 CONTENT[/col]";
								out += "[col]COLUMN 5 CONTENT[/col]";
								out += "[col]COLUMN 6 CONTENT[/col]";
								out += "[/col6]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 6 COLUMNS MENU ITEM ###
				},
				
				{
					// ###################################
					// ### 2/3 + 1/3 COLUMNS MENU ITEM ###
					// ###################################
					text: '2/3 + 1/3 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '2/3 + 1/3 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '767' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap2', label: '- Gap for 2 Column mode', value: '5' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '8' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[thirds_2to1";
								if (e.data.break1 != '') {
									out += " break='" + e.data.break1 + "'";
								}
								if ((e.data.gap2 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap2 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[/thirds_2to1]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 2/3 + 1/3 COLUMNS MENU ITEM ###
				},
				
				{
					// ###################################
					// ### 1/3 + 2/3 COLUMNS MENU ITEM ###
					// ###################################
					text: '1/3 + 2/3 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '1/3 + 2/3 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '767' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap2', label: '- Gap for 2 Column mode', value: '5' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '8' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[thirds_1to2";
								if (e.data.break1 != '') {
									out += " break='" + e.data.break1 + "'";
								}
								if ((e.data.gap2 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap2 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[/thirds_1to2]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 1/3 + 2/3 COLUMNS MENU ITEM ###
				},
				
				{
					// ###################################
					// ### 3/4 + 1/4 COLUMNS MENU ITEM ###
					// ###################################
					text: '3/4 + 1/4 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '3/4 + 1/4 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '767' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap2', label: '- Gap for 2 Column mode', value: '5' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '8' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[quarters_3to1";
								if (e.data.break1 != '') {
									out += " break='" + e.data.break1 + "'";
								}
								if ((e.data.gap2 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap2 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[/quarters_3to1]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 3/4 + 1/4 COLUMNS MENU ITEM ###
				},
				
				{
					// ###################################
					// ### 1/4 + 3/4 COLUMNS MENU ITEM ###
					// ###################################
					text: '1/4 + 3/4 Columns',
					onclick: function() {
						editor.windowManager.open({
							// ### POPUP WINDOW CONTENT ###
							title: '1/4 + 3/4 COLUMNS',
							body: [
								{ type: 'container', label: 'RESPONSIVE BREAKPOINTS', html: '<span style="color:#a0a0a0;">(in pixels)</span>' },
								{ type: 'textbox', name: 'break1', label: '- Switch to 1 Column mode at', value: '767' },
								{ type: 'container', label: 'COLUMN GAPS', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'gap2', label: '- Gap for 2 Column mode', value: '5' },
								{ type: 'textbox', name: 'gap1', label: '- Gap for 1 Column mode', value: '8' },
								{ type: 'container', label: 'WRAPPER PADDING', html: '<span style="color:#a0a0a0;">(in percent)</span>' },
								{ type: 'textbox', name: 'padd_vert', label: '- Top/Bottom Padding', value: '0' },
								{ type: 'textbox', name: 'padd_hori', label: '- Left/Right Padding', value: '0' },
								{ type: 'container', label: 'OTHER OPTIONS' },
								{ type: 'listbox', name: 'align', label: '- Column Text Align', 'values': [
									{text: 'Left', value: 'left'},
									{text: 'Center', value: 'center'},
									{text: 'Right', value: 'right'}
								]},
								{ type: 'listbox', name: 'valign', label: '- Column Vertical Align', 'values': [
									{text: 'Top', value: 'top'},
									{text: 'Middle', value: 'middle'},
									{text: 'Bottom', value: 'bottom'}
								]},
								{ type: 'textbox', name: 'wrap_id', label: '- Wrapper CSS ID'  },
								{ type: 'checkbox', name: 'strip_tags', label: '- Strip <p> and <br/> Tags'  },
							],
							onsubmit: function(e) {
								// INSERT SHORTCODE INTO EDITOR WINDOW
								var out =  "[quarters_1to3";
								if (e.data.break1 != '') {
									out += " break='" + e.data.break1 + "'";
								}
								if ((e.data.gap2 != '') && (e.data.gap1 != '')) {
									out += " gap='" + e.data.gap2 + "," + e.data.gap1 + "'";
								}
								if ((e.data.padd_vert != '') && (e.data.padd_hori != '')) {
									out += " wrap_padd='" + e.data.padd_vert + "," + e.data.padd_hori + "'";
								}
								out += " align='" + e.data.align + "'";
								out += " valign='" + e.data.valign + "'";
								if (e.data.wrap_id != '') {
									out += " wrap_id='" + e.data.wrap_id + "'";
								}
								if (e.data.strip_tags != '') {
									out += " strip_tags='y'";
								}
								out += "]";
								out += "[col]COLUMN 1 CONTENT[/col]";
								out += "[col]COLUMN 2 CONTENT[/col]";
								out += "[/quarters_1to3]";
								editor.insertContent(out);
							}
						});	
					}
					// ### END - 1/4 + 3/4 COLUMNS MENU ITEM ###
				}
				
			]	
		});
	});
})();
