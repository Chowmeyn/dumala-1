/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
/**
 * @module image/imageresize/ui/imagecustomresizeformview
 */
import { ButtonView, FocusCycler, LabeledFieldView, View, ViewCollection, type FocusableView, type InputNumberView } from 'ckeditor5/src/ui.js';
import { FocusTracker, KeystrokeHandler, type Locale } from 'ckeditor5/src/utils.js';
import '../../../theme/imagecustomresizeform.css';
import '@ckeditor/ckeditor5-ui/theme/components/responsive-form/responsiveform.css';
/**
 * The ImageCustomResizeFormView class.
 */
export default class ImageCustomResizeFormView extends View {
    /**
     * Tracks information about the DOM focus in the form.
     */
    readonly focusTracker: FocusTracker;
    /**
     * An instance of the {@link module:utils/keystrokehandler~KeystrokeHandler}.
     */
    readonly keystrokes: KeystrokeHandler;
    /**
     * Resize unit shortcut.
     */
    readonly unit: string;
    /**
     * An input with a label.
     */
    labeledInput: LabeledFieldView<InputNumberView>;
    /**
     * A button used to submit the form.
     */
    saveButtonView: ButtonView;
    /**
     * A button used to cancel the form.
     */
    cancelButtonView: ButtonView;
    /**
     * A collection of views which can be focused in the form.
     */
    protected readonly _focusables: ViewCollection<FocusableView>;
    /**
     * Helps cycling over {@link #_focusables} in the form.
     */
    protected readonly _focusCycler: FocusCycler;
    /**
     * An array of form validators used by {@link #isValid}.
     */
    private readonly _validators;
    /**
     * @inheritDoc
     */
    constructor(locale: Locale, unit: string, validators: Array<ImageCustomResizeFormValidatorCallback>);
    /**
     * @inheritDoc
     */
    render(): void;
    /**
     * @inheritDoc
     */
    destroy(): void;
    /**
     * Creates the button view.
     *
     * @param label The button label
     * @param icon The button's icon.
     * @param className The additional button CSS class name.
     * @param eventName The event name that the ButtonView#execute event will be delegated to.
     * @returns The button view instance.
     */
    private _createButton;
    /**
     * Creates an input with a label.
     *
     * @returns Labeled field view instance.
     */
    private _createLabeledInputView;
    /**
     * Validates the form and returns `false` when some fields are invalid.
     */
    isValid(): boolean;
    /**
     * Cleans up the supplementary error and information text of the {@link #labeledInput}
     * bringing them back to the state when the form has been displayed for the first time.
     *
     * See {@link #isValid}.
     */
    resetFormStatus(): void;
    /**
     * The native DOM `value` of the input element of {@link #labeledInput}.
     */
    get rawSize(): string | null;
    /**
     * Get numeric value of size. Returns `null` if value of size input element in {@link #labeledInput}.is not a number.
     */
    get parsedSize(): number | null;
    /**
     * Returns serialized image input size with unit.
     * Returns `null` if value of size input element in {@link #labeledInput}.is not a number.
     */
    get sizeWithUnits(): string | null;
}
/**
 * Callback used by {@link ~ImageCustomResizeFormView} to check if passed form value is valid.
 *
 * 	* If `undefined` is returned, it is assumed that the form value is correct and there is no error.
 * 	* If string is returned, it is assumed that the form value is incorrect and the returned string is displayed in the error label
 */
export type ImageCustomResizeFormValidatorCallback = (form: ImageCustomResizeFormView) => string | undefined;
/**
 * Fired when the form view is submitted.
 *
 * @eventName ~ImageCustomResizeFormView#submit
 */
export type ImageCustomResizeFormViewSubmitEvent = {
    name: 'submit';
    args: [];
};
/**
 * Fired when the form view is canceled.
 *
 * @eventName ~ImageCustomResizeFormView#cancel
 */
export type ImageCustomResizeFormViewCancelEvent = {
    name: 'cancel';
    args: [];
};
