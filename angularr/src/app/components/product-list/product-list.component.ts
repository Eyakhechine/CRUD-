import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ProductService } from '../../services/product.service';
import { Product } from '../../models/product.model';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.css'],
})
export class ProductListComponent implements OnInit {
  products: Product[] = [];
  productForm: FormGroup;
  editing: boolean = false; // To toggle between add and edit mode

  constructor(private productService: ProductService, private fb: FormBuilder) {
    // Initialize the form
    this.productForm = this.fb.group({
      id: [''], // Hidden when adding
      name: ['', Validators.required],
    });
  }

  ngOnInit(): void {
    this.loadProducts();
  }

  loadProducts(): void {
    this.productService.getProducts().subscribe({
      next: (data) => (this.products = data),
      error: (error) => console.error('There was an error!', error),
    });
  }

  initializeForm(product?: Product): void {
    this.editing = !!product;
    this.productForm.reset();
    if (product) {
      this.productForm.setValue({
        id: product.id,
        name: product.name,
      });
    } else {
      this.productForm.setValue({
        id: '',
        name: '',
      });
    }
  }

  submitForm(): void {
    const product: Product = this.productForm.value;
    if (this.editing) {
      this.productService.updateProduct(product).subscribe({
        next: () => this.loadProducts(),
        error: (error) => console.error('Error updating product!', error),
      });
    } else {
      this.productService.createProduct(product).subscribe({
        next: () => this.loadProducts(),
        error: (error) => console.error('Error adding product', error),
      });
    }
  }

  deleteProduct(id: number): void {
    this.productService.deleteProduct(id).subscribe({
      next: () => this.loadProducts(),
      error: (error) => console.error('Error deleting product!', error),
    });
  }
}
