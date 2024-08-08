import { injectable} from "inversify";
import { User } from "../entities/User";

@injectable()
export class UsersUseCase {
    getUsers() : User [] {
        return [
            new User(1, "John Doe", "johnd@example.com"),
            new User(2, "Luyanda Siko", "sikoluyanda@gmail.com")
        ];
    }
}