/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

( e => {
const { [ 'nb' ]: { dictionary, getPluralForm } } = {"nb":{"dictionary":{"Unlink":"Fjern lenke","Link":"Lenke","Link URL":"URL for lenke","Link URL must not be empty.":"","Link image":"","Edit link":"Rediger lenke","Open link in new tab":"Åpne lenke i ny fane","This link has no URL":"Denne lenken har ingen URL","Open in a new tab":"","Downloadable":"","Create link":"","Move out of a link":""},getPluralForm(n){return (n != 1);}}};
e[ 'nb' ] ||= { dictionary: {}, getPluralForm: null };
e[ 'nb' ].dictionary = Object.assign( e[ 'nb' ].dictionary, dictionary );
e[ 'nb' ].getPluralForm = getPluralForm;
} )( window.CKEDITOR_TRANSLATIONS ||= {} );
