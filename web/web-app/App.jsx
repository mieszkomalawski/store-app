import React from 'react';

class App extends React.Component{


    constructor() {
        super();
        this.state = {
            name: '',
            price: 0,
            products: []
        };

        this.onSubmitHandler = this.onSubmitHandler.bind(this);
        this.onChangeNameHandler = this.onChangeNameHandler.bind(this);
        this.onChangePriceHandler = this.onChangePriceHandler.bind(this);
    }

    onSubmitHandler(event) {
        alert(event.target.value);
        event.preventDefault();
    }

    onChangeNameHandler(event) {
        let value = event.target.value;
        let tmpState = this.state;
        tmpState.name = value;
        tmpState.products.push({
            name: value,
            price: this.state.price
        });
        this.setState(tmpState);
    }

    onChangePriceHandler(event) {
        let value = event.target.value;
        let tmpState = this.state;
        tmpState.price = value;
        tmpState.products.push({
            price: value,
            name: this.state.name
        });
        this.setState(tmpState);
    }

    render() {
        return (
            <div>
                <AddProductForm
                     name={this.state.name}
                     price={this.state.price}
                    onSubmit={this.onSubmitHandler}
                    onChangeName={this.onChangeNameHandler}
                     onChangePrice={this.onChangePriceHandler}
                />
                <ProductList  rows={this.state.products}  />
            </div>
        );
    }

}

class AddProductForm extends React.Component{
    render(){
        return (
            <div>
                <form onSubmit={this.props.onSubmit}>
                    <label htmlFor="name" />
                    <input type="text" name="name" onChange={this.props.onChangeName} value={this.props.name}/>
                    <label htmlFor="price" />
                    <input type="text" name="price" onChange={this.props.onChangePrice} value={this.props.price}/>
                    <input type="submit" value="Dodaj produkt"/>
                </form>
            </div>
        )
    }
}

class ProductList extends React.Component {
    render() {
        const listItems = this.props.rows.map((product) =>
            <ProductRow name={product.name} price={product.price} />
        );

        return (
            <div>
                {listItems}
            </div>
        )
    }
}

class ProductRow extends React.Component {
    render() {
        return (
            <div>
                <input type="text" value={this.props.name} disabled="disabled" />
                <input type="text" value={this.props.price} disabled="disabled" />
            </div>
        )
    }
}



export default App;