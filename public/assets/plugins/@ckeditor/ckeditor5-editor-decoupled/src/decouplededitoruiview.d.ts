/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
/**
 * @module editor-decoupled/decouplededitoruiview
 */
import { EditorUIView, InlineEditableUIView, MenuBarView, ToolbarView } from 'ckeditor5/src/ui.js';
import type { Locale } from 'ckeditor5/src/utils.js';
import type { EditingView } from 'ckeditor5/src/engine.js';
/**
 * The decoupled editor UI view. It is a virtual view providing an inline
 * {@link module:editor-decoupled/decouplededitoruiview~DecoupledEditorUIView#editable},
 * {@link module:editor-decoupled/decouplededitoruiview~DecoupledEditorUIView#toolbar}, and a
 * {@link module:editor-decoupled/decouplededitoruiview~DecoupledEditorUIView#menuBarView} but without any
 * specific arrangement of the components in the DOM.
 *
 * See {@link module:editor-decoupled/decouplededitor~DecoupledEditor.create `DecoupledEditor.create()`}
 * to learn more about this view.
 */
export default class DecoupledEditorUIView extends EditorUIView {
    /**
     * The main toolbar of the decoupled editor UI.
     */
    readonly toolbar: ToolbarView;
    /**
     * Menu bar view instance.
     */
    readonly menuBarView: MenuBarView;
    /**
     * The editable of the decoupled editor UI.
     */
    readonly editable: InlineEditableUIView;
    /**
     * Creates an instance of the decoupled editor UI view.
     *
     * @param locale The {@link module:core/editor/editor~Editor#locale} instance.
     * @param editingView The editing view instance this view is related to.
     * @param options Configuration options for the view instance.
     * @param options.editableElement The editable element. If not specified, it will be automatically created by
     * {@link module:ui/editableui/editableuiview~EditableUIView}. Otherwise, the given element will be used.
     * @param options.shouldToolbarGroupWhenFull When set `true` enables automatic items grouping
     * in the main {@link module:editor-decoupled/decouplededitoruiview~DecoupledEditorUIView#toolbar toolbar}.
     * See {@link module:ui/toolbar/toolbarview~ToolbarOptions#shouldGroupWhenFull} to learn more.
     */
    constructor(locale: Locale, editingView: EditingView, options?: {
        editableElement?: HTMLElement;
        shouldToolbarGroupWhenFull?: boolean;
    });
    /**
     * @inheritDoc
     */
    render(): void;
}
