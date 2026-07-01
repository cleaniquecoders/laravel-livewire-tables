# Introduction

Earlier iterations of the package relied on third-party Sortable plugins. These are no longer required — reordering uses the bundled assets and Livewire.

## An update about reordering

If you have a large data set to sort, then it is recommended that you create a minimal table instance with only the required columns for performance reasons.

The field keys used in the reorder() function have been updated, and allow for easier upserting/reuse of reorder code.

The reorder will not be saved until you click the "Save" button.
