/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

( e => {
const { [ 'zh-cn' ]: { dictionary, getPluralForm } } = {"zh-cn":{"dictionary":{"Cancel":"取消","Clear":"清除","Remove color":"移除颜色","Restore default":"恢复默认","Save":"保存","Show more items":"显示更多","%0 of %1":"第 %0 步，共 %1 步","Cannot upload file:":"无法上传的文件：","Rich Text Editor. Editing area: %0":"富文本编辑器。编辑区域：%0","Insert with file manager":"使用文件管理器插入","Replace with file manager":"使用文件管理器替换","Insert image with file manager":"使用文件管理器插入图片","Replace image with file manager":"使用文件管理器替换图片","File":"文件","With file manager":"通过文件管理器","Toggle caption off":"关闭表标题","Toggle caption on":"打开表标题","Content editing keystrokes":"内容编辑按键","These keyboard shortcuts allow for quick access to content editing features.":"这些键盘快捷键允许快速访问内容编辑功能。","User interface and content navigation keystrokes":"用户界面和内容导航按键","Use the following keystrokes for more efficient navigation in the CKEditor 5 user interface.":"使用以下按键可以在 CKEditor 5 用户界面中进行更有效地导览。","Close contextual balloons, dropdowns, and dialogs":"关闭上下文气泡框、下拉菜单和对话框","Open the accessibility help dialog":"打开“无障碍辅助功能帮助”对话框","Move focus between form fields (inputs, buttons, etc.)":"在表单字段（输入、按钮等）之间移动焦点","Move focus to the menu bar, navigate between menu bars":"将焦点移到菜单栏，在菜单栏之间导航","Move focus to the toolbar, navigate between toolbars":"将焦点移至工具栏，在工具栏之间导览","Navigate through the toolbar or menu bar":"通过工具栏或菜单栏进行导航","Execute the currently focused button. Executing buttons that interact with the editor content moves the focus back to the content.":"执行当前聚焦的按钮。执行与编辑器内容交互的按钮将焦点返回到内容。","Accept":"接受"},getPluralForm(n){return 0;}}};
e[ 'zh-cn' ] ||= { dictionary: {}, getPluralForm: null };
e[ 'zh-cn' ].dictionary = Object.assign( e[ 'zh-cn' ].dictionary, dictionary );
e[ 'zh-cn' ].getPluralForm = getPluralForm;
} )( window.CKEDITOR_TRANSLATIONS ||= {} );
