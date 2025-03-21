/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

( e => {
const { [ 'pt' ]: { dictionary, getPluralForm } } = {"pt":{"dictionary":{"Open file manager":"Abrir gestor de ficheiros","Cannot determine a category for the uploaded file.":"Não é possível determinar a categoria do ficheiro carregado.","Cannot access default workspace.":"Não é possível aceder ao espaço de trabalho padrão.","Edit image":"Editar imagem","Processing the edited image.":"A processar a imagem editada.","Server failed to process the image.":"O servidor não conseguiu processar a imagem.","Failed to determine category of edited image.":"Não foi possível determinar a categoria da imagem editada."},getPluralForm(n){return (n == 0 || n == 1) ? 0 : n != 0 && n % 1000000 == 0 ? 1 : 2;}}};
e[ 'pt' ] ||= { dictionary: {}, getPluralForm: null };
e[ 'pt' ].dictionary = Object.assign( e[ 'pt' ].dictionary, dictionary );
e[ 'pt' ].getPluralForm = getPluralForm;
} )( window.CKEDITOR_TRANSLATIONS ||= {} );
