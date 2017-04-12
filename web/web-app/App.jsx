import React from 'react';
import rest from 'rest';
import mime from 'rest/interceptor/mime';
import entity from 'rest/interceptor/entity';

class App extends React.Component{

    componentDidMount() {
        this.endpointUrl = 'http://localhost:8080/product';

        this.client = rest
            .chain(mime, { mime: 'application/json' })
            .chain(entity);

        this.client({ path: this.endpointUrl })
            .then((response) => {
                let tmpState = this.state;
                tmpState.products = response.data;
                this.setState(tmpState);
            });
    }

    constructor() {
        super();
        this.state = {
            form: {
                name: '',
                price: 0,
            },
            products: []
        };

        this.onSubmitHandler = this.onSubmitHandler.bind(this);
        this.onChangeNameHandler = this.onChangeNameHandler.bind(this);
        this.onChangePriceHandler = this.onChangePriceHandler.bind(this);
    }

    onSubmitHandler(event) {

        event.preventDefault();

        this.client({ path: this.endpointUrl, method: "POST", params: {
            name: this.state.form.name,
            price: this.state.form.price
        } })
            .then((response) => {
                console.log(response);
            });

        // let tmpState = this.state;
        // tmpState.products.push({
        //     name: this.state.form.name,
        //     price: this.state.form.price
        // });
        // this.setState(tmpState);

    }

    onChangeNameHandler(event) {
        let value = event.target.value;
        let tmpState = this.state;
        tmpState.form.name = value;
        this.setState(tmpState);
    }

    onChangePriceHandler(event) {
        let value = event.target.value;
        let tmpState = this.state;
        tmpState.form.price = value;
        this.setState(tmpState);
    }

    render() {
        return (
            <div>
                <AddProductForm
                     name={this.state.form.name}
                     price={this.state.form.price}
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
        const listItems = this.props.rows.map((product, index) =>
            <ProductRow key={index} name={product.name} price={product.price} />
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