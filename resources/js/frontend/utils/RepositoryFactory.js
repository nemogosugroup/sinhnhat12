import UserRepository from '@frontend/api/user/index';
import RoleRepository from '@frontend/api/role';
import ProjectRepository from '@frontend/api/project';
import langRepository from '@frontend/api/lang/index';
import mapRepository from '@frontend/api/map/index';
import game2048Repository from '@frontend/api/game2048';
import questsRepository from '@frontend/api/quests';
const repositories = {
    user: UserRepository,
    role: RoleRepository,
    project: ProjectRepository,
    lang: langRepository,
    map: mapRepository,
    game2048: game2048Repository,
    quests: questsRepository
};
const RepositoryFactory = {
    get: (name) => repositories[name]
};
export default RepositoryFactory;
