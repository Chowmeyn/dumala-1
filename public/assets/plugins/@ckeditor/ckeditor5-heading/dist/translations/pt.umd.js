/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

( e => {
const { [ 'pt' ]: { dictionary, getPluralForm } } = {"pt":{"dictionary":{"Paragraph":"Parágrafo","Heading":"Cabeçalho","Choose heading":"Escolher cabeçalho","Heading 1":"Cabeçalho 1","Heading 2":"Cabeçalho 2","Heading 3":"Cabeçalho 3","Heading 4":"Cabeçalho 4","Heading 5":"Cabeçalho 5","Heading 6":"Cabeçalho 6","Type your title":"Introduza o seu título","Type or paste your content here.":"Digite ou cole o seu conteúdo aqui."},getPluralForm(n){return (n == 0 || n == 1) ? 0 : n != 0 && n % 1000000 == 0 ? 1 : 2;}}};
e[ 'pt' ] ||= { dictionary: {}, getPluralForm: null };
e[ 'pt' ].dictionary = Object.assign( e[ 'pt' ].dictionary, dictionary );
e[ 'pt' ].getPluralForm = getPluralForm;
} )( window.CKEDITOR_TRANSLATIONS ||= {} );
