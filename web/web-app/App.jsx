import React from 'react';

class App extends React.Component{


    constructor() {
        super();
        this.state = {
            name: '',
            price: 0
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
        this.setState(tmpState);
    }

    onChangePriceHandler(event) {
        let value = event.target.value;
        let tmpState = this.state;
        tmpState.price = value;
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

export default App;